<?php

namespace App\Http\Controllers;

use App\Models\Nurse;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;


class NurseController extends Controller
{

    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required'
        ]);

        $nurse = new Nurse();
        $nurse->name                            =   $request->name;
        $nurse->email                           =   $request->email;
        $nurse->password                        =   bcrypt($request->password);
        $nurse->is_reference_verified           =   0;
        $nurse->save();
        $token = $nurse->createToken('myapptoken')->plainTextToken;
        $response = [
            'token' => $token
        ];
        return response($response, 201);
    }


    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = Nurse::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'token' => $token
        ];

        return response($response, 201);
    }



        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->user();
        $nurse = Nurse::find($data->id);
        $nurse->name                            =   $request->name;
        $nurse->email                           =   $request->email;
        $nurse->password                        =   bcrypt($request->password);
        $nurse->is_reference_verified           =   0;
        $nurse->save();
                 
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->user();
        $nurse = Nurse::find($data->id);
        $nurse->forceDelete();       
    
    }
}