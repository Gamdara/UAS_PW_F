<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Keranjang::where('user_id',auth()->user()->id)->with('buku')->get();

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
        
        $validate = Validator::make($storeData, Keranjang::$rules);

        if($validate->fails())
            return response(['status' => false,'message' => $validate->errors()], 400);

        $data = Keranjang::firstOrNew(['user_id' => auth()->user()->id, 'buku_id' => $request->buku_id]);
        $data->jumlah = $request->jumlah;
        $data->save();
        
        return response([
            'status' => true,
            'message' => 'Add data Success',
            'data' => $data,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Keranjang  $Keranjang
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = Keranjang::where(['user_id' => auth()->user()->id, 'buku_id' => $id])->with('buku')->first();
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
     * @param  \App\Models\Keranjang  $Keranjang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //jadi satu sama create
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Keranjang  $Keranjang
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = Keranjang::where(['user_id' => auth()->user()->id, 'buku_id' => $id])->first();

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

    public function destroyAll()
    {
        //
        $data = Keranjang::where(['user_id' => auth()->user()->id])->delete();

        if($data){
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
