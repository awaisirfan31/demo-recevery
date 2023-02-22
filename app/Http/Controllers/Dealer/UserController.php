<?php

namespace App\Http\Controllers\Dealer;

use Carbon\Carbon;
use App\City;
use App\User;
use App\Adjustment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role != 3)
        {
            return redirect()->back();
        }
        $users = User::where('refered_by', Auth::user()->id)->orderBy('id','asc')->get();
        return view('dealer.user.user', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'national_id' => 'required|string|unique:users',
            'mobile' => 'required|string|numeric|unique:users',
            'address' => 'required|string',
            'package_name' => 'required|string',
            'package_price' => 'required|numeric',
        ]);
        if($validator->fails()) 
        {
            return response()->json(['error'=>$validator->errors()]);
        }
        else
        {            
            $exists_user = User::where('city_id', Auth::user()->city_id)->orderBy('id','desc')->first(); 
            
            $add_user = new User();
            $add_user->name = $request->name;
            $add_user->email = $request->email;
            $add_user->national_id = $request->national_id;
            $add_user->phone = $request->phone;
            $add_user->mobile = $request->mobile;
            $add_user->address = $request->address;
            $add_user->refered_by = Auth::user()->id;
            $add_user->package_name = $request->package_name;
            $add_user->package_price = $request->package_price;
            $add_user->city_id = Auth::user()->city_id;      
            $add_user->area_id = Auth::user()->area_id;  
            if($exists_user)
            {                
                $add_user->user_id = $exists_user->user_id + 1;
            }
            else
            {
                $city = City::where('id', Auth::user()->city_id)->first();
                $add_user->user_id = $city->city_id . '00001';
            }
            $add_user->payment_date = Carbon::now();
            
            if($add_user->save())
            {
                $adjustment = new Adjustment();
                $adjustment->user_id = $add_user->id;
                $adjustment->save();
                return response()->json(['success'=>'User Created Successfully']); 
            }
            else
            {
                return response()->json(['error'=>'User Is Not Created Successfully']); 
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        return response()->json(['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email',
            'national_id' => 'required|string',
            'mobile' => 'required|string|numeric',
            'address' => 'required|string',
            'package_name' => 'required|string',
            'package_price' => 'required|numeric',
        ]);
        if($validator->fails()) 
        {
            return response()->json(['error'=>$validator->errors()]);
        }
        else
        {
            if(User::where('email', $request->email)->where('id', '!=', $id)->exists())
            {
                return response()->json(['error_custom'=>'This Email is already used']); 
            }
            if(User::where('national_id', $request->national_id)->where('id', '!=', $id)->exists())
            {
                return response()->json(['error_custom'=>'This National ID is already used']); 
            }
            if(User::where('mobile', $request->mobile)->where('id', '!=', $id)->exists())
            {
                return response()->json(['error_custom'=>'This Mobile is already used']); 
            }
           
            
            
            $update_user = User::find($id);

            $update_user->name = $request->name;
            $update_user->email = $request->email;
            $update_user->national_id = $request->national_id;
            $update_user->phone = $request->phone;
            $update_user->mobile = $request->mobile;
            $update_user->address = $request->address;
            $update_user->package_name = $request->package_name;
            $update_user->package_price = $request->package_price;
            
            if($update_user->save())
            {
                return response()->json(['success'=>'User update successfully']);
            }
            else
            {
                return response()->json(['error'=>'User not update successfully']);
            }
     
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_user = User::find($id);
        if ($delete_user->delete()) {
            return response()->json(['success'=>'This User deleted Successfully']);
        }

        else  {
            return response()->json(['error'=>'This User not deleted Successfully']);
        }
    }
}
