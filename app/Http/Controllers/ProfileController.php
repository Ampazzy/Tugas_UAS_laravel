<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

class ProfileController extends Controller
{
    public function index()
    {
        //get posts
        $posts = Post::All();

        //render view with posts
        return view('profiles.index', compact('posts'));
    }

}