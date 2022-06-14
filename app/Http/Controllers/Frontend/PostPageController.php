<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PostPageController extends Controller
{
    public function index(Post $post)
    {
        if ('unpublish' == $post->status) {
            return abort(404);
        }

        $menusResponse = nova_get_menu_by_slug('header');
        $menus         = $menusResponse['menuItems'];

        $recent_update = Post::orderBy('updated_at', 'DESC')
            ->select('slug')
            ->where('post_type', 'listing')
            ->where('status', 'publish')
            ->limit(6)
            ->get();
        $top_visited = Post::orderBy('page_views', 'DESC')
            ->select('slug')
            ->where('post_type', 'listing')
            ->where('status', 'publish')
            ->limit(6)
            ->get();
        $recent_added = Post::orderBy('created_at', 'DESC')
            ->select('slug')
            ->where('post_type', 'listing')
            ->where('status', 'publish')
            ->limit(6)
            ->get();

        //  $post = $post->where('status', 'publish');

        $post->update([
            'page_views' => DB::raw('page_views + 1'),
        ]);

        return view('themes.manvendra.content.post',
            [
                'post'          => $post,
                'menus'         => $menus,
                'recent_update' => $recent_update,
                'top_visited'   => $top_visited,
                'recent_added'  => $recent_added,
            ]);
    }
}
