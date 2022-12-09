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
        $reviews = Review::all();
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
        // store review book api
        // take all data from request
        $data = $request->all();


        // validate data
        $validate = Validator::make($data, [
            'id_user' => 'required',
            'id_buku' => 'required',
            'nilai' => 'required|numeric|between:1,5',
            'komentar' => 'required',
        ]);


        // if validation failed
        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors(),
            ], 400);
        }

        // if validation success

        // store review
        $review = Review::create($data);
        // return response
        return response()->json([
            'status' => 'success',
            'data' => $review,
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
        //update review
        // take all data from request
        $data = $request->all();

        // validate data
        $validate = Validator::make($data, [
            'id_user' => 'required',
            'id_buku' => 'required',
            'nilai' => 'required|numeric|between:1,5',
            'komentar' => 'required',
        ]);

        // if validation failed
        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors(),
            ], 400);
        }

        // if validation success
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

        // update review
        $review->update($data);

        // return response
        return response()->json([
            'status' => 'success',
            'data' => $review,
        ], 200);
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
