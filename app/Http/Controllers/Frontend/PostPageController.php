<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PostPageController extends Controller
{
    public function index(Post $post)
    {

        $post->update([
            'page_views' => DB::raw('page_views + 1'),
        ]);

        return view('themes.manvendra.content.post',
            [
                'post' => $post,

            ]);
    }
}
