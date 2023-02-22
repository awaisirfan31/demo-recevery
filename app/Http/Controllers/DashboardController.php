<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Admin;
use App\Ledger;
use App\Adjustment;
use Illuminate\Support\Facades\Auth;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->role == 1)
        {
            $all_users = User::count();
            $payment = Ledger::where('type', 'Recovery')
            ->whereMonth('updated_at', Carbon::now()->month)->sum('payment');
            $otc = Ledger::where('type', 'Recovery')
            ->whereMonth('updated_at', Carbon::now()->month)->sum('otc');
            $received_payments = $payment + $otc;

            $remaining_payment = User::where('status', '2')->sum('package_price');

            $advance_payments = Adjustment::whereMonth('updated_at', Carbon::now()->month)->sum('advance_payment');
            $pending_payments = Adjustment::whereMonth('updated_at', Carbon::now()->month)->sum('pending_payment');
            $resent_sale = Ledger::join('users','users.id','ledgers.payable_id')
            ->select('users.name','ledgers.payment','ledgers.invoice_id')->orderBy('ledgers.id','desc')->take(25)->get();
            
        }
        else if(Auth::user()->role == 2)
        {
            $all_users = 0;
            $payment = 0;
            $otc = 0;
            $remaining_payment = 0;
            $advance_payments = 0;
            $pending_payments = 0;

            $admins = Admin::where('refered_by', Auth::user()->id)->get();
            
            foreach($admins as $admin)
            {
                $inner_count = User::where('refered_by', $admin->id)->count();
                $all_users += $inner_count;

                $inner_payment = Ledger::where('type', 'Recovery')->where('receivable_id', $admin->id)
                ->whereMonth('updated_at', Carbon::now()->month)->sum('payment');
                $payment += $inner_payment;

                $inner_otc = Ledger::where('type', 'Recovery')->where('receivable_id', $admin->id)
                ->whereMonth('updated_at', Carbon::now()->month)->sum('otc');
                $otc += $inner_otc;

                $inner_remaining_payment = User::where('status', '2')->where('refered_by', $admin->id)
                ->sum('package_price');
                $remaining_payment += $inner_remaining_payment;

                $inner_advance_payments = Adjustment::join('ledgers', 'adjustments.user_id', 'ledgers.payable_id')
                ->where('ledgers.receivable_id', $admin->id)
                ->whereMonth('adjustments.updated_at', Carbon::now()->month)->sum('adjustments.advance_payment');
                $advance_payments += $inner_advance_payments;

                $inner_pending_payments = Adjustment::join('ledgers', 'adjustments.user_id', 'ledgers.payable_id')
                ->where('ledgers.receivable_id', $admin->id)
                ->whereMonth('adjustments.updated_at', Carbon::now()->month)->sum('adjustments.pending_payment');
                $pending_payments += $inner_pending_payments;
                
                
            }

            $resent_sale = Ledger::join('users','users.id','ledgers.payable_id')
            ->select('users.name','ledgers.payment','ledgers.invoice_id')->where('ledgers.admin_id',Auth::user()->id)
            ->orderBy('ledgers.id','desc')->take(25)->get();
            $received_payments = $payment + $otc;

        }
        else if(Auth::user()->role == 3)
        {
            $all_users = User::where('refered_by', Auth::user()->id)->count();

            $payment = Ledger::where('type', 'Recovery')->where('receivable_id', Auth::user()->id)
            ->whereMonth('updated_at', Carbon::now()->month)->sum('payment');
            $otc = Ledger::where('type', 'Recovery')->where('receivable_id', Auth::user()->id)
            ->whereMonth('updated_at', Carbon::now()->month)->sum('otc');
            $received_payments = $payment + $otc;

            $remaining_payment = User::where('status', '2')->where('refered_by', Auth::user()->id)
            ->sum('package_price');

            $advance_payments = Adjustment::join('ledgers', 'adjustments.user_id', 'ledgers.payable_id')
            ->where('ledgers.receivable_id', Auth::user()->id)
            ->whereMonth('adjustments.updated_at', Carbon::now()->month)->sum('adjustments.advance_payment');
            $pending_payments = Adjustment::join('ledgers', 'adjustments.user_id', 'ledgers.payable_id')
            ->where('ledgers.receivable_id', Auth::user()->id)
            ->whereMonth('adjustments.updated_at', Carbon::now()->month)->sum('adjustments.pending_payment');
            $resent_sale = Ledger::join('users','users.id','ledgers.payable_id')
            ->select('users.name','ledgers.payment','ledgers.invoice_id')
            ->where('refered_by',Auth::user()->id)->orderBy('ledgers.id','desc')->take(25)->get();
        }

       
       
        return view('dashboard', compact('all_users', 'received_payments', 'remaining_payment',
            'advance_payments', 'pending_payments','resent_sale'));
    }
    public function graph()
    {
        
        $month_name=array();
        $month_sales=array();
        $month_revinue=array();
        $users=array();
        if(Auth::user()->role == 1)
        {
            $months = Ledger::select(

                DB::raw("(SUM(payment)) as payment"),
                DB::raw("month as month_name"),
                DB::raw("SUM(otc) as otc"),
                DB::raw("SUM(advance_payment) as advance_payment"),
                DB::raw("SUM(pending_payment) as pending_payments"),
                DB::raw("COUNT(payable_id) as users"),
            )
            ->whereBetween('month', 
            [Carbon::now()->subMonth(6)->format('MY'), Carbon::now()->format('MY')])
            ->groupBy('month_name')
            ->get()->toArray();

            foreach($months as $month)
            {
                $month_name[] = $month['month_name'];
                $month_sales[] = $month['payment'];
                $month_revinue[] = ($month['payment'] + $month['otc']+$month['advance_payment'])-($month['pending_payments']);
                $users[] = ($month['users']);
            }
                    
        }
        else if(Auth::user()->role == 2)
        {
            $months = Ledger::select(

                DB::raw("(SUM(payment)) as payment"),
                DB::raw("month as month_name"),
                DB::raw("SUM(otc) as otc"),
                DB::raw("SUM(advance_payment) as advance_payment"),
                DB::raw("SUM(pending_payment) as pending_payments"),
                DB::raw("COUNT(payable_id) as users"),
            )
            ->whereBetween('month', 
            [Carbon::now()->subMonth(6)->format('MY'), Carbon::now()->format('MY')])
            ->where('admin_id',Auth::user()->id)
            ->groupBy('month_name')
            ->get()->toArray();

            foreach($months as $month)
            {
                $month_name[] = $month['month_name'];
                $month_sales[] = $month['payment'];
                $month_revinue[] = ($month['payment'] + $month['otc']+$month['advance_payment'])-($month['pending_payments']);
                $users[] = ($month['users']);
            }

        }
        else if(Auth::user()->role == 3)
        {
            $months = Ledger::select(

                DB::raw("(SUM(payment)) as payment"),
                DB::raw("month as month_name"),
                DB::raw("SUM(otc) as otc"),
                DB::raw("SUM(advance_payment) as advance_payment"),
                DB::raw("SUM(pending_payment) as pending_payments"),
                DB::raw("COUNT(payable_id) as users"),
            )
            ->whereBetween('month', 
            [Carbon::now()->subMonth(6)->format('MY'), Carbon::now()->format('MY')])
            ->where('receivable_id',Auth::user()->id)
            ->groupBy('month_name')
            ->get()->toArray();
            
            foreach($months as $month)
            {
                $month_name[] = $month['month_name'];
                $month_sales[] = $month['payment'];
                $month_revinue[] = ($month['payment'] + $month['otc']+$month['advance_payment'])-($month['pending_payments']);
                $users[] = ($month['users']);
            }
        
          
        }

       
       
        return response()->json(['users'=>$users,'sales'=>$month_sales,'revinue'=>($month_revinue),'months'=>$month_name]);
    }
}
