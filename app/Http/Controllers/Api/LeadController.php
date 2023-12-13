<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\Lead;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make(
            $data,
            [
                'name' => 'required|min:3|max:255',
                'email' => 'required|min:3|max:255',
                'message' => 'required|min:3'
            ],
            [
                'name.required' => 'name is required',
                'name.min' => 'the name must be longer than :min characters',
                'name.max' => 'the name must be greater than :max characters',
                'email.required' => 'email is required',
                'email.min' => 'the email must be longer than :min characters',
                'email.max' => 'the email must be greater than :max characters',
                'message.required' => 'message is required',
                'message.min' => 'the message must be longer than :min characters '
            ]
        );

        if ($validator->fails()) {
            $success = false;
            $errors = $validator->errors();
            return response()->json(compact('success', 'errors'));
        }

        $new_lead = new Lead();
        $new_lead->fill($data);
        $new_lead->save();

        Mail::to('infoboolean@gmail.com')->send(new NewContact($new_lead));

        $success = true;

        return response()->json(compact('success'));
    }
}
