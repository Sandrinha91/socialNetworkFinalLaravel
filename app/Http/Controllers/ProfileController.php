<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    public function viewProfile($id)
    {
        //nadjemo korisnika za zadatim id-ijerm
        //User::find($id); // ne mora da postoji pk
        $user = User::findOrFail($id); // mora da postoji pk
        $posts = $user->posts()->orderBy('created_at', 'desc')->get();
        return view('profile', array( 'user' => $user, 'posts' => $posts )); // ovo posts je zapravo na osnovu metode posts() iz klase User
    }
}
