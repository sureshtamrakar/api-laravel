<?php

namespace App\Http\Controllers;

use App\Models\Reference;
use App\Models\Nurse;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Mail;


class ReferenceController extends Controller
{

    public function login(Request $request)

    {

        $fields = $request->validate([
            'email' => 'required|string'
        ]);

        // Check email
        $user = Reference::where('email', $fields['email'])->first();

        // Check password
        

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201
);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->user();
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required'
        ]);
        if ($validator->fails()) {
            return 'Name and Email Fields Required';
        }
        $reference = new Reference();
        $reference->name            =   $request->name;
        $reference->email           =   $request->email;
        $reference->save();
        return url("/reference/update/{$reference->id}/{$data->id}");
/*         Mail::send('reference-email.send', ['id' => $reference->id], function ($message) use ($request) {
            $message->from('hello@app.com', 'Reference');
            $message->to($request->email);
        }); */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,$rid)
    {
        $reference = Reference::findOrFail($id);
        if ($request->email !== $reference->email) {
            return 'Email Not Matched';
        }
        $reference->name                =   $request->name;
        $reference->email               =   $request->email;
        $reference->designation         =   $request->designation;
        $reference->worked_from         =   $request->worked_from;
        $reference->address             =   $request->address;
        $reference->company_name        =   $request->company_name;
        $reference->worked_to           =   $request->worked_to;
        $reference->would_rehire        =   $request->would_rehire;
        $reference->work_quality        =   $request->work_quality;
        $reference->can_handle_stress   =   $request->can_handle_stress;
        $reference->save();
        $nurse = Nurse::find($rid);
        if ( $request->would_rehire == 1 && $request->can_handle_stress == 1) {
            $nurse->is_reference_verified           =   1;
            $nurse->save();  
        }

    }


    public function ref_update(Request $request,$email)
    {
        $fields = $request->validate([
            'email' => 'required|string'
        ]);

        // Check email
        $reference = Reference::where('email', $email)->first();
        $reference->name                =   $request->name;
        $reference->email               =   $request->email;
        $reference->save();
    }

}
