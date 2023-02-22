<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Area;
use App\City;
use App\User;
use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role != 2)
        {
            return redirect()->back();
        }
        $areas = Area::where('created_by', Auth::user()->id)->orderBy('id','asc')->get();
        $dealers = Admin::join('areas', 'areas.id', 'admins.area_id')
        ->select('admins.*', 'areas.area_name','areas.id as ar_id')
        ->where('admins.role','3')->where('admins.refered_by', Auth::user()->id)->orderBy('id', 'asc')->get();
        return view('admin.dealer.dealer', compact('dealers','areas'));
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
            'username' => 'required|string|unique:admins',
            'email' => 'required|string|email|unique:admins',
            'national_id' => 'required|string|unique:admins',
            'mobile' => 'required|string|numeric|unique:admins',
            'address' => 'required|string',
            'password' => 'required',
            'area_id' => 'required|string',
        ]);
        if($validator->fails()) 
        {
            return response()->json(['error'=>$validator->errors()]);
        }
        else
        {            
            $exists_admin = Admin::where('city_id', Auth::user()->city_id)->orderBy('id','desc')->first(); 
            $add_dealer = new Admin();
            $add_dealer->name = $request->name;
            $add_dealer->username = $request->username;
            $add_dealer->email = $request->email;
            $add_dealer->national_id = $request->national_id;
            $add_dealer->phone = $request->phone;
            $add_dealer->mobile = $request->mobile;
            $add_dealer->address = $request->address;
            $add_dealer->password = Hash::make($request->password);
            $add_dealer->role = 3;
            $add_dealer->refered_by = Auth::user()->id;
            $add_dealer->city_id = Auth::user()->city_id;      
            $add_dealer->area_id = $request->area_id;      
                  
            if($exists_admin)
            {                
                $add_dealer->admin_id = $exists_admin->admin_id + 1;
            }
            else
            {
                $city = City::where('id', Auth::user()->city_id)->first();
                $add_dealer->admin_id = $city->city_id . '00001';
            }
            $add_dealer->expiry_date = Auth::user()->expiry_date;
            
            if($add_dealer->save())
            {
                return response()->json(['success'=>'Dealer Created Successfully']); 
            }
            else
            {
                return response()->json(['error'=>'Dealer Is Not Created Successfully']); 
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
        $dealer = Admin::where('id', $id)->first();
        return response()->json(['dealer'=>$dealer]);
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
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'national_id' => 'required|string',
            'mobile' => 'required|string|numeric',
            'address' => 'required|string',
        ]);
        if($validator->fails()) 
        {
            return response()->json(['error'=>$validator->errors()]);
        }
        else
        {
            
            if(Admin::where('national_id', $request->national_id)->where('id', '!=', $id)->exists())
            {
                return response()->json(['error_custom'=>'This National ID is already used']); 
            }
            if(Admin::where('mobile', $request->mobile)->where('id', '!=', $id)->exists())
            {
                return response()->json(['error_custom'=>'This Mobile is already used']); 
            }
            $update_dealer = Admin::find($id);
            $update_dealer->name = $request->name;
            $update_dealer->national_id = $request->national_id;
            $update_dealer->phone = $request->phone;
            $update_dealer->mobile = $request->mobile;
            $update_dealer->address = $request->address;
            $update_dealer->area_id = $request->area_id;
            if($request->password)
            {
                $update_dealer->password = Hash::make($request->password);
            }
            if($update_dealer->save())
            {
                return response()->json(['success'=>'Dealer update successfully']);
            }
            else
            {
                return response()->json(['error'=>'Dealer not update successfully']);
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
        $delete_dealer = Admin::find($id);
        if(User::where('refered_by', $id)->exists())
        {
            return response()->json(['error'=>'This dealer have users']);
        }
        if ($delete_dealer->delete()) {
            return response()->json(['success'=>'This Dealer deleted Successfully']);
        }

        else  {
            return response()->json(['error'=>'This Dealer not deleted Successfully']);
        }
    }
}
