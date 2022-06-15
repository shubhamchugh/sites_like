<?php

namespace App\Http\Controllers\Scrape;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Scrape\Get_Screenshot;

class ScreenshotScrapeController extends Controller
{
    public function screenshot_scrape(Request $request)
    {
        $status = !empty($request->status) ? $request->status : "pending";

        $domain = Post::where('is_screenshot', $status)
            ->where('post_type', 'listing')
            ->orderBy('status', 'ASC')
            ->first();

        if (empty($domain)) {
            return "No Record Found Please check Database";
        }

        $domain->update([
            'is_screenshot' => 'scraping',
        ]);

        $screenshot = Get_Screenshot::screenshot_wasabi($domain->slug);

        if (empty($screenshot) && 'pending' !== $status) {
            $domain->update([
                'is_seo_analyzer' => 'discard',
            ]);
            echo "Something bad with analyzing seo with $domain->slug";
            die;
        }

        if (empty($screenshot)) {
            $domain->update([
                'is_seo_analyzer' => 'fail',
            ]);
            echo "Something bad with analyzing seo with $domain->slug";
            die;
        }

        $screenshot_store = Post::updateOrCreate(['id' => $domain->id], [
            'thumbnail' => $screenshot['thumbnail'],
            'favicon'   => $screenshot['favicon'],
        ]);
        $domain->update([
            'is_screenshot' => 'done',
        ]);
        return $screenshot_store;

    }
}
