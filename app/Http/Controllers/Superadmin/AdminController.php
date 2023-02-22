<?php

namespace App\Http\Controllers\Superadmin;

use Carbon\Carbon;
use App\City;
use App\Logo;
use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role != 1)
        {
            return redirect()->back();
        }
        $cities = City::orderBy('id','asc')->get();
        $admins = Admin::where('role','2')->orderBy('id', 'asc')->get();
        return view('superadmin.admin.admin', compact('admins','cities'));
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
            'city_id' => 'required|string',
            'logo' => 'required|mimes:jpg,png,gif|max:10000',
        ]);
        if($validator->fails()) 
        {
            return response()->json(['error'=>$validator->errors()]);
        }
        else
        {            
            $exists_admin = Admin::where('city_id', $request->city_id)->orderBy('id','desc')->first(); 
            $add_admin = new Admin();
            $add_admin->name = $request->name;
            $add_admin->username = $request->username;
            $add_admin->email = $request->email;
            $add_admin->national_id = $request->national_id;
            $add_admin->phone = $request->phone;
            $add_admin->mobile = $request->mobile;
            $add_admin->address = $request->address;
            $add_admin->password = Hash::make($request->password);
            $add_admin->role = 2;
            $add_admin->refered_by = Auth::user()->id;
            $add_admin->city_id = $request->city_id;            
            if($exists_admin)
            {
                
                $add_admin->admin_id = $exists_admin->admin_id + 1;
            }
            else
            {
                $city = City::where('id', $request->city_id)->first();
                $add_admin->admin_id = $city->city_id . '00001';
            }
            if($request->expiry_date)
            {
                // $created = new Carbon($request->expiry_date);
                // $now = Carbon::now();
                // $difference = ($created->diff($now)->days > 28);
                // if(!$difference)
                // {
                //     return response()->json(['error_custom'=>'Expiry Date Should be atleast 1 month']); 
                // }
                $add_admin->expiry_date = $request->expiry_date;
            }
            else
            {        
                $add_admin->expiry_date = Carbon::now()->addDay(30);
            }


            
            if($add_admin->save())
            {
                if($request->hasFile('logo'))
                {
                    $file      = $request->file('logo');
                    $filename  = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $picture   = uniqid().'.'.$extension;
                    $file->move(public_path() . '/assets/img/logos/admin', $picture);
    
                    $add_logo = new Logo();
                    $add_logo->admin_id = $add_admin->id;
                    $add_logo->image_path = $picture;
                    $add_logo->save();
                }            
                return response()->json(['success'=>'Admin Created Successfully']); 
            }
            else
            {
                return response()->json(['error'=>'Admin Is Not Created Successfully']); 
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
        $admin = Admin::where('id', $id)->first();
        return response()->json(['admin'=>$admin]);
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
           
            
            
            $update_admin = Admin::find($id);

            $update_admin->name = $request->name;
            $update_admin->national_id = $request->national_id;
            $update_admin->phone = $request->phone;
            $update_admin->mobile = $request->mobile;
            $update_admin->address = $request->address;
            if($request->password)
            {
                $update_admin->password = Hash::make($request->password);
            }
            if($request->expiry_date)
            {
                $update_admin->expiry_date = $request->expiry_date;
            }
            else
            {        
                $update_admin->expiry_date = Carbon::now()->addDay(30);
            }
            if($update_admin->save())
            {

                if($request->hasFile('logo'))
                {
                    $file      = $request->file('logo');
                    $filename  = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $picture   = uniqid().'.'.$extension;
                    $file->move(public_path() . '/assets/img/logos/admin', $picture);
    
                    if(Logo::where('admin_id', $id)->exists())
                    {
                        $add_logo = Logo::where('admin_id', $id)->first();
                    }
                    else
                    {
                        $add_logo = new Logo();
                        $add_logo->admin_id = $id;
                    }
                    $add_logo->image_path = $picture;
                    $add_logo->save();
                }           
                
                return response()->json(['success'=>'Admin update successfully']);
            }
            else
            {
                return response()->json(['error'=>'Admin not update successfully']);
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
        $delete_amin = Admin::find($id);
        if(Admin::where('refered_by', $id)->exists())
        {
            return response()->json(['error'=>'This Admin have dealers']);
        }
        if ($delete_amin->delete()) {
            return response()->json(['success'=>'This Admin deleted Successfully']);
        }
        else  {
            return response()->json(['error'=>'This Admin not deleted Successfully']);
        }
    }
}

