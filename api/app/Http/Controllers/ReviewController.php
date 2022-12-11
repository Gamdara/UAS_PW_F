<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //test
        $reviews = Review::with('user')->get();
        return response()->json([
            'success' => true,
            'message' => 'Daftar Data Review',
            'data' => $reviews
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
        // validate data
        $validate = Validator::make($request->all(), Review::$rules);

        // if validation failed
        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors(),
            ], 400);
        }

        // store review
        $data = Review::firstOrNew(['user_id' => auth()->user()->id, 'buku_id' => $request->buku_id]);
        $data->nilai = $request->nilai;
        $data->komentar = $request->komentar;
        $data->save();

        // return response
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        // show review by ID
        // find review by id
        $review = Review::find($review->id);
        // if review not found
        if (!$review) {
            return response()->json([
                'status' => 'error',
                'message' => 'review not found',
            ], 404);
        }
        // if review found
        return response()->json([
            'status' => 'success',
            'data' => $review,
        ], 200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        // jadi satu sama create
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
