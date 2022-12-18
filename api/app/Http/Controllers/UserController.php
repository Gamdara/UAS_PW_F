<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //show profile Auth user

    public function showProfile()
    {
        $user = auth()->user();
        return response()->json([
            'status' => true,
            'message' => 'Profile User',
            'data' => $user
        ], 200);
    }

    // update auth user

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $data = $request->all();
        if($request->hasFile('foto')) $data['foto'] = ImageUpload::uploadImage($request, 'foto');
        // validate data user
        $validate = Validator::make($data, [
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required',
            'no_hp' => 'required',
        ]);

        // if validation failed
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validate->errors()
            ], 400);
        }
        
        if(array_key_exists('password',$data)) $data['password'] = Hash::make($data['password']);

        // update data user
        $user = User::find($user->id);
        $user->update($data);
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile Updated',
            'data' => $user
        ], 200);


    }
}
