<?php

namespace App\Http\Controllers;

use App\Models\Penulis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenulisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Penulis::all();

        return response([
            'status' => true,
            'message' => 'Retrieve All Success',
            'data' => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $storeData = $request->all();
        
        $validate = Validator::make($storeData, Penulis::$rules);

        if($validate->fails())
            return response(['status' => false,'message' => $validate->errors()], 400);

        $data = Penulis::create($storeData);
        return response([
            'status' => true,
            'message' => 'Add data Success',
            'data' => $data,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penulis  $Penulis
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = Penulis::find($id);
        if(!is_null($data)){
            return response([
                'status' => true,
                'message' => 'Retrieve data Success',
                'data' => $data,
            ], 200);
        }

        return response([
            'status' => false,
            'message' => 'data Not Found',
            'data' => null,
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penulis  $Penulis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = Penulis::find($id);

        if(is_null($data)){
            return response([
                'message' => 'data Not Found',
                'data' => null,
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, Penulis::$rules);

        if($validate->fails())
            return response(['status'=>false,'message' => $validate->errors()], 400);

        if($data->update($updateData)){
            return response([
                'status'=>true,
                'message' => 'Update data Success',
                'data' => $data,
            ], 200);
        }

        return response([
            'status'=>false,
            'message' => 'Update data Failed',
            'data' => $data,
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penulis  $Penulis
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = Penulis::find($id);

        if(is_null($data)){
            return response([
                'status'=>false,
                'message' => 'data Not Found',
                'data' => null,
            ], 404);
        }

        if($data->delete()){
            return response([
                'status'=>true,
                'message' => 'Delete data Success',
                'data' => $data,
            ], 200);
        }

        return response([
            'status'=>false,
            'message' => 'Delete data Failed',
            'data' => null,
        ], 400);
    }
}
