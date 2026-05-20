<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $pageTitle = "Favorite Services";
        $favorites = Favorite::where('user_id', auth()->id())->with('service', 'service.category')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('Template::user.favorite', compact('pageTitle', 'favorites'));
    }

    public function add(Request $request)
    {
        $favorite = Favorite::where('service_id', $request->id)->where('user_id', auth()->id())->first();
        if ($favorite) {
            $favorite->delete();
            $action = "delete";
            $msg = "Remove favourite successfully!";
        } else {
            $favorite = new Favorite();
            $favorite->service_id = $request->id;
            $favorite->user_id = auth()->id();
            $favorite->save();
            $action = "add";
            $msg = "Make favourite successfully!";
        }
        return response()->json(
            [
                'action' => $action,
                'notification' => $msg
            ]
        );
    }
}
