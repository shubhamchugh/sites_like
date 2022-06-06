<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class PostPageController extends Controller
{
    public function index()
    {
        return view('themes.manvendra.content.post');
    }
}
