<?php

namespace App\Http\Controllers\Dealer;

use Carbon\Carbon;
use App\Logo;
use App\User;
use App\Admin;
use App\Ledger;
use App\Payment;
use PDF;
use App\Adjustment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function Payment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'package_price' => 'required|numeric',
            'next_recovery_date' => 'required|date',
        ]);
        if($validator->fails()) 
        {
            return response()->json(['error'=>$validator->errors()]);
        }
        else
        {  
            $payment = new Ledger();
            $invoice_id = Ledger::invoice_id();
            $payment->type = 'Recovery';
            $payment->receivable_id = Auth::user()->id;
            $payment->payable_id = $request->id;
            $payment->payment = $request->package_price;
            $payment->otc = $request->otc;
            $payment->advance_payment= $request->advance_payment;
            $payment->pending_payment = $request->pending_payment;
            $payment->next_recovery_date = $request->next_recovery_date;
            $payment->admin_id = Auth::user()->refered_by;
            $payment->month = Carbon::now()->format('MY');
            $payment->save();
            $payment->invoice_id = $invoice_id + $payment->id;
            $payment->save();
            $adjustment = Adjustment::where('user_id',$request->id)->first();
            if($request->advance_payment)
            {
                $adjustment->advance_payment = $request->advance_payment;
            }
            else
            {
                $adjustment->advance_payment = 0;
            }
            if($request->pending_payment)
            {
                $adjustment->pending_payment = $request->pending_payment;
            }
            else
            {
                $adjustment->pending_payment = 0;
            }
            $adjustment->save();
            User::where('id',$request->id)->update(['status' => '1', 'payment_date'=>$request->next_recovery_date]);

            return response()->json(['success'=>'Invoice Paid Successfully']);   

        }   
    }
    public function AdjustmentDetail(Request $request)
    {
        $adjustment = Adjustment::where('user_id',$request->id)->first();
        $package = User::select('package_name')->where('id', $request->id)->first();
        return response()->json(['adjustment'=>$adjustment, 'package'=>$package]);
    }
    public function ViewInvoice(Request $request)
    {
        
        $logo = Logo::where('admin_id', Auth::user()->refered_by)->first();
        $admin = Admin::where('id', Auth::user()->id)->select('name','email','mobile')->first();
        $payment = ledger::where('id', $request->id)->select('otc','payable_id','payment', 'advance_payment', 'pending_payment', 'created_at')
        ->orderBy('id', 'desc')->first();
      
        $user = User::where('id',$payment->payable_id)->select('name','id')->first();
        return view('dealer.user.invoice', compact('logo', 'admin', 'user', 'payment'));
    }
    public function Invoice(Request $request)
    {

        $invoices = ledger::where('payable_id', $request->id)->select('id', 'otc', 'payment', 'advance_payment', 'pending_payment', 'created_at','invoice_id')
        ->orderBy('id', 'desc')->get();
        return view('dealer.user.invoice-list', compact('invoices'));
    }
    public function downloadInvoice(Request $request)
    {

        $logo = Logo::where('admin_id', Auth::user()->refered_by)->first();
        $admin = Admin::where('id', Auth::user()->id)->select('name','email','mobile')->first();
        $payment = ledger::where('id', $request->id)->select('otc','payable_id','payment', 'advance_payment', 'pending_payment', 'created_at')
        ->orderBy('id', 'desc')->first();
      
        $user = User::where('id',$payment->payable_id)->select('name')->first();
        $data =[
            'logo' => $logo,
            'admin' => $admin,
            'user' => $user,
            'payment' => $payment,
        ];

        $pdf = PDF::loadView('dealer.user.download-invoice',$data); 
        $path = storage_path('pdf/paid');
        // $path = public_path('/assets/pdf'); // <--- folder to store the pdf documents into the server;
        $fileName =  $user->username.'-'.$latest_history->invoice_month.'.'. 'pdf' ; // <--giving the random filename,
        if(File::exists(storage_path('pdf/non-paid/'.$fileName))){
            File::delete(storage_path('pdf/non-paid/'.$fileName));
        }
      
        $pdf->save($path . '/' . $fileName);
        
        // return view('dealer.user.invoice-list', compact('invoices'));
    }
    public function printInvoice(Request $request)
    {

        $logo = Logo::where('admin_id', Auth::user()->refered_by)->first();
        $admin = Admin::where('id', Auth::user()->id)->select('name','email','mobile')->first();
        $payment = ledger::where('id', $request->id)->select('otc','payable_id','payment', 'advance_payment', 'pending_payment', 'created_at')
        ->orderBy('id', 'desc')->first();
      
        $user = User::where('id',$payment->payable_id)->select('name','id')->first();
        $data =[
            'logo' => $logo,
            'admin' => $admin,
            'user' => $user,
            'payment' => $payment,
        ];

        return view('dealer.user.print-invoice', compact('logo', 'admin', 'user', 'payment'));
        
        
        // return view('dealer.user.invoice-list', compact('invoices'));
    }
    
    


}
