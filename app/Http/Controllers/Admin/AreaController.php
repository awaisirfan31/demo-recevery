<?php

namespace App\Http\Controllers\Admin;

use App\Area;
use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
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
        $areas = Area::where('created_by', Auth::user()->id)->orderby('id', 'asc')->get();
        return view('admin.area.area', compact('areas'));
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
            'area_name' => 'required|string|unique:areas',   
        ]);
        if($validator->fails()) 
        {
            return response()->json(['error'=>$validator->errors()]);
        }
        else
        {
            $add_area = new Area();
            $add_area->area_name = $request->area_name;
            $add_area->city_id = Auth::user()->city_id;
            $add_area->created_by = Auth::user()->id;
            
            if($add_area->save())
            {
                return response()->json(['success'=>'Area Created Successfully']); 
            }
            else
            {
                return response()->json(['error'=>'Area Is Not Created Successfully']); 
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
        $area = Area::where('id', $id)->first();
        return response()->json(['area'=>$area]);
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
            'area_name' => 'required|string'
        ]);
        if($validator->fails()) 
        {
            return response()->json(['error'=>$validator->errors()]);
        }
        else
        {
            if(Area::where('area_name', $request->area_name)->where('id', '!=', $id)->exists())
            {
                return response()->json(['error_custom'=>'This area name is already used']); 
            }
            else
            {
                $update_area = Area::find($id);
                $update_area->area_name = $request->area_name;
                
                if($update_area->save())
                {
                    return response()->json(['success'=>'Area update successfully']);
                }
                else
                {
                    return response()->json(['error'=>'Area not update successfully']);
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
        $delete_area = Area::find($id);
        if(Admin::where('area_id', $id)->exists())
        {
            return response()->json(['error'=>'This area have dealers']);
        }
        if ($delete_area->delete()) {
            return response()->json(['success'=>'This Area deleted Successfully']);
        }

        else  {
            return response()->json(['error'=>'This Area not deleted Successfully']);
        }
    }
}
