<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Ledger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\carbon;
use DataTables;
use DB;
use Illuminate\Support\Str; 
class LedgerController extends Controller
{
    public function showLedger(Request $request)
    { 
        $ledger=array();
        if(Auth::user()->role == 1)
        {
            $ledgers = Ledger::join('admins', 'admins.id', 'ledgers.receivable_id')
            ->join('users', 'users.id', 'ledgers.payable_id')
            ->select('ledgers.*', 'admins.name as admin_name', 'admins.admin_id', 'users.name as user_name', 'users.user_id')
            ->whereDate('ledgers.created_at', Carbon::today())->get();
        }
        else if(Auth::user()->role == 2)
        {
            $ledgers = Ledger::join('admins', 'admins.id', 'ledgers.receivable_id')
            ->join('users', 'users.id', 'ledgers.payable_id')
            ->select('ledgers.*', 'admins.name as admin_name', 'admins.admin_id', 'users.name as user_name', 'users.user_id')
            ->where('ledgers.admin_id', Auth::user()->id)->whereDate('ledgers.created_at', Carbon::today())->get();;
        }
        else if(Auth::user()->role == 3)
        {
            $ledgers = Ledger::join('admins', 'admins.id', 'ledgers.receivable_id')
            ->join('users', 'users.id', 'ledgers.payable_id')
            ->select('ledgers.*', 'admins.name as admin_name', 'admins.admin_id', 'users.name as user_name', 'users.user_id')
            ->where('ledgers.receivable_id', Auth::user()->id)
            ->where('ledgers.type', 'Recovery')
            ->whereDate('ledgers.created_at', Carbon::today())
            ->get();
           
        }
        
        return view('ledger', compact('ledgers'));
    }
    // public function showLedger(Request $request)
    // {
    //     if ($request->ajax()) {
    //         if(Auth::user()->role == 1)
    //         {
    //             $data = Ledger::join('admins', 'admins.id', 'ledgers.receivable_id')
    //             ->join('users', 'users.id', 'ledgers.payable_id')
    //             ->select('ledgers.*', 'admins.name as admin_name', 'admins.admin_id', 'users.name as user_name', 'users.user_id')
    //             ->whereDate('ledgers.created_at', Carbon::today())->get();
    //             // dd($data);
    //         }
    //         else if(Auth::user()->role == 2)
    //         {
    //             $data = Ledger::join('admins', 'admins.id', 'ledgers.receivable_id')
    //             ->join('users', 'users.id', 'ledgers.payable_id')
    //             ->select('ledgers.*', 'admins.name as admin_name', 'admins.admin_id', 'users.name as user_name', 'users.user_id')
    //             ->where('ledgers.admin_id', Auth::user()->id)->whereDate('ledgers.created_at', Carbon::today())->get();;
    //         }
    //         else if(Auth::user()->role == 3)
    //         {
    //             $data = Ledger::join('admins', 'admins.id', 'ledgers.receivable_id')
    //             ->join('users', 'users.id', 'ledgers.payable_id')
    //             ->select('ledgers.*', 'admins.name as admin_name', 'admins.admin_id', 'users.name as user_name', 'users.user_id')
    //             ->where('ledgers.receivable_id', Auth::user()->id)
    //             ->where('ledgers.type', 'Recovery')
    //             ->whereDate('ledgers.created_at', Carbon::today())
    //             ->get();
               
    //         }

            
          
    //         return Datatables::of($data)

    //                 ->addIndexColumn()

    //                 ->filter(function ($instance) use ($request) {
    //                     // if (!empty($request->get('search'))) {

    //                     //     $instance->collection = $instance->collection->filter(function ($row) use ($request) {

    //                     //         if (Str::contains(Str::lower($row['type']), Str::lower($request->get('search')))){

    //                     //             return true;

    //                     //         }
    //                     //         else if (Str::contains(Str::lower($row['admin_name']), Str::lower($request->get('search')))) {

    //                     //             return true;

    //                     //         }
    //                     //         else if (Str::contains(Str::lower($row['user_name']), Str::lower($request->get('search')))) {

    //                     //             return true;

    //                     //         }

   

    //                     //         return false;

    //                     //     });

    //                     // }

   

    //                 })

    //                 ->make(true);

                   
    //     }

    
      
    //     // $ledger=array();
    //     // if(Auth::user()->role == 1)
    //     // {
    //     //     $ledgers = Ledger::join('admins', 'admins.id', 'ledgers.receivable_id')
    //     //     ->join('users', 'users.id', 'ledgers.payable_id')
    //     //     ->select('ledgers.*', 'admins.name as admin_name', 'admins.admin_id', 'users.name as user_name', 'users.user_id')
    //     //     ->whereDate('ledgers.created_at', Carbon::today())->get();
    //     // }
    //     // else if(Auth::user()->role == 2)
    //     // {
    //     //     $ledgers = Ledger::join('admins', 'admins.id', 'ledgers.receivable_id')
    //     //     ->join('users', 'users.id', 'ledgers.payable_id')
    //     //     ->select('ledgers.*', 'admins.name as admin_name', 'admins.admin_id', 'users.name as user_name', 'users.user_id')
    //     //     ->where('ledgers.admin_id', Auth::user()->id)->whereDate('ledgers.created_at', Carbon::today())->get();;
    //     // }
    //     // else if(Auth::user()->role == 3)
    //     // {
    //     //     $ledgers = Ledger::join('admins', 'admins.id', 'ledgers.receivable_id')
    //     //     ->join('users', 'users.id', 'ledgers.payable_id')
    //     //     ->select('ledgers.*', 'admins.name as admin_name', 'admins.admin_id', 'users.name as user_name', 'users.user_id')
    //     //     ->where('ledgers.receivable_id', Auth::user()->id)
    //     //     ->where('ledgers.type', 'Recovery')
    //     //     ->whereDate('ledgers.created_at', Carbon::today())
    //     //     ->get();
           
    //     // }
        
    //     // return view('ledger', compact('ledgers'));
    // }
}
