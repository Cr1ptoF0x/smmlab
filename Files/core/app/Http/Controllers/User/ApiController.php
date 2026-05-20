<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    //Api Documentation
    public function api()
    {
        $pageTitle = 'API Documentation';
        return view('Template::user.api.index', compact('pageTitle'));
    }

    public function generateApiKey()
    {
        $user          = auth()->user();
        $user->api_key = sha1(time());
        $user->save();
        $notify[] = ['success', 'Generated new api key!'];
        return back()->withNotify($notify);
    }
}
