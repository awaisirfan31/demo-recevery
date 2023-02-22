<?php

namespace App\Http\Controllers\Superadmin;

use App\City;
use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
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
        $cities = City::orderby('id', 'asc')->get();
        return view('superadmin.city.city', compact('cities'));
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
            'city_name' => 'required|string|unique:cities',   
        ]);
        if($validator->fails()) 
        {
            return response()->json(['error'=>$validator->errors()]);
        }

        $exists_city = City::orderBy('id','desc')->first();

        $add_city = new City();
        $add_city->city_name = $request->city_name;
        if($exists_city)
        {
            $add_city->city_id = $exists_city->city_id+1;
        }
        else
        {
            $add_city->city_id = '100';
        }
        if($add_city->save())
        {
            return response()->json(['success'=>'City Created Successfully']); 
        }
        else
        {
            return response()->json(['error'=>'City Is Not Created Successfully']); 
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
        $city = City::where('id', $id)->first();
        return response()->json(['city'=>$city]);
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
            'city_name' => 'required|string'
        ]);
        if($validator->fails()) 
        {
            return response()->json(['error'=>$validator->errors()]);
        }
        else
        {
            if(City::where('city_name', $request->city_name)->where('id', '!=', $id)->exists())
            {
                return response()->json(['error_custom'=>'This city name is already used']); 
            }
            else
            {
                $update_city = City::find($id);
                $update_city->city_name = $request->city_name;
                
                if($update_city->save())
                {
                    return response()->json(['success'=>'City update successfully']);
                }
                else
                {
                    return response()->json(['error'=>'City not update successfully']);
                }
     
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
        $delete_city = City::find($id);
        if(Admin::where('city_id', $id)->exists())
        {
            return response()->json(['error'=>'This area have admins']);
        }
        if ($delete_city->delete()) {
            return response()->json(['success'=>'This City deleted Successfully']);
        }

        else  {
            return response()->json(['error'=>'This City not deleted Successfully']);
        }
    }
}
