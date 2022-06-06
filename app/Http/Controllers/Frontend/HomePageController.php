<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    public function index()
    {
        $posts = Post::with(
            'seo_analyzers_relation',
            'ip_record_relation',
            'Ssl_Details_relation'
        )
            ->where('post_type', 'listing')
            ->where('status', 'publish')
            ->paginate(10);
        return view('themes.manvendra.content.home', [
            'posts' => $posts,
        ]);
    }
}
