<?php

namespace App\Http\Controllers\api;

use App\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactPost;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Validator;

class ContactController extends ApiResponseController
{
    public function store(Request $request){
       //dd($request->all());
        $validator = Validator::make($request->all(), StoreContactPost::myRules());

        if($validator->fails()){
            return $this->errorResponse($validator->errors());
        }else{
            //dd($validator->validated());
            $contact = Contact::create($validator->validated());

            SendEmail::dispatch($contact->email,$contact->name.' '.$contact->surname);

            return $this->successResponse("exito");
        }

    }
}
