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
            ->orderBy('id', 'DESC')
            ->paginate(10);

        if (empty($posts->first())) {
            return "<h1>Please do some scrape to get data</h1>";
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

        return view('themes.manvendra.content.home', [
            'posts'         => $posts,
            'menus'         => $menus,
            'recent_update' => $recent_update,
            'top_visited'   => $top_visited,
            'recent_added'  => $recent_added,
        ]);
    }
}
