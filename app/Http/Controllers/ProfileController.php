<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Crypt;

class ProfileController extends Controller
{
    public function ShowProfile($id)
    {
        $profile = Admin::find(Crypt::decrypt($id));
        $logo = Logo::where('admin_id',Crypt::decrypt($id))->first();
        if(!$logo)
        {
            $logo = null;
        }
        return view('profile',compact('profile','logo'));
    }
    public function ProfileUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'national_id' => 'required|string',
            'mobile' => 'required|string|numeric',
            'address' => 'required|string'
        ]);
        if($validator->fails()) 
        {
            return response()->json(['error'=>$validator->errors()]);
        }
        else
        {
            if(Admin::where('national_id', $request->national_id)->where('id', '!=', Auth::user()->id)->exists())
            {
                return response()->json(['error_custom'=>'This National ID is already used']); 
            }
            if(Admin::where('mobile', $request->mobile)->where('id', '!=', Auth::user()->id)->exists())
            {
                return response()->json(['error_custom'=>'This Mobile is already used']); 
            }
           
            
            
            $update_profile = Admin::find(Auth::user()->id);

            $update_profile->name = $request->name;
            $update_profile->national_id = $request->national_id;
            $update_profile->phone = $request->phone;
            $update_profile->mobile = $request->mobile;
            $update_profile->address = $request->address;
            
            if($update_profile->save())
            {
                return response()->json(['success'=>'Profile update successfully']);
            }
            else
            {
                return response()->json(['error'=>'Profile not update successfully']);
            }
     
            
        }
    }
    public function PasswordUpdate(Request $request)
    {
       
        $validator = Validator::make($request->all(), ['old_password' => 'required',
        'password' => 'required|string|max:255|confirmed'
        ]);
        if($validator->fails()) 
        {
            return response()->json(['error'=>$validator->errors()],402);
        }  
        else
        {
            $current_password= $request->old_password;
            $new_password=$request->password;
            $show_old_password = Admin::find(Auth::user()->id);
           
            if (!(Hash::check($current_password, $show_old_password->password))) {
                return response()->json(['error'=>'Current password is incorrect'],400);
            }
             else {
                
                if (strcmp($current_password, $new_password) == 0) {
                     return response()->json(['error'=>'New Password cannot be same as your current password. Please choose a different password.'],400);
                   
                }
                 else {   
                    $data=Admin::where('id', '=', Auth::user()->id)->update(['password' => Hash::make($new_password)]);
                   
                    if($data)
                    {
                        
                        return response()->json(['success'=> 'Password has been change successfully'],200);
                    }
                    else
                    {
                        return response()->json(['error'=> 'Password has been not change successfully'],400);
                    }
                }
            }
        }
    }
    public function statusChange(Request $request)
    {
       $status = Admin::where('id',$request->id)->update(['status'=>$request->status]);
       if($status)
       {
            return response()->json(['success'=>'status has been updated'],200);
       }
       else
       {
         return response()->json(['error'=>'status has not been updated'],400);
       }
    }
}
