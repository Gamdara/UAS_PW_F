<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Buku::with(['penulis','genre','review'])->get();
        
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
        
        if($request->hasFile('cover')) $storeData['cover'] = ImageUpload::uploadImage($request, 'cover');

        $validate = Validator::make($storeData, Buku::$rules);

        if($validate->fails())
            return response(['status' => false,'message' => $validate->errors()], 400);

        $data = Buku::create($storeData);
        
        return response([
            'status' => true,
            'message' => 'Add data Success',
            'data' => $data,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Buku  $Buku
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = Buku::with(['penulis','genre','review','review.user'])->find($id);
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
     * @param  \App\Models\Buku  $Buku
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = Buku::find($id);

        if(is_null($data)){
            return response([
                'message' => 'data Not Found',
                'data' => null,
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, Buku::$rules);

        if($request->hasFile('cover')) $updateData['cover'] = ImageUpload::uploadImage($request, 'cover');

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
     * @param  \App\Models\Buku  $Buku
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = Buku::find($id);

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
