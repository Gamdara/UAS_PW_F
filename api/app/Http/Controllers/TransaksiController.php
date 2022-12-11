<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //alll transaction book
        $transaksi = Transaksi::with('details','details.bukus')->get();
        return response()->json([
            'success' => true,
            'message' => 'Daftar Data Transaksi',
            'data' => $transaksi
        ], 200);
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
        //store book transaction
        //take all data from request
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        //validate data
        $validate = Validator::make($data, Transaksi::$rules);

        // if validate fail
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'data' => $validate->errors()
            ], 400);
        }

        // if validate success
        // check if book is available
        // $buku = Buku::find($data['buku_id']);
        // if ($buku->stok < $data['jumlah']) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Stok buku tidak cukup',
        //         'data' => null
        //     ], 400);
        // }

        // if book is available
        // update book stock
        // $buku->stok = $buku->stok - $data['jumlah'];
        // $buku->save();

        $transaksi = Transaksi::create($data);
        $details = $transaksi->details()->createMany($data['details']);

        return $transaksi;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi)
    {
        //show 1 transactin by id
        $transaksi = Transaksi::with('details','details.bukus')->find($transaksi->id);

        //if transaction not found
        if (!$transaksi) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'data' => null
            ], 400);
        }

        //if transaction found
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Transaksi',
            'data' => $transaksi
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }
}
