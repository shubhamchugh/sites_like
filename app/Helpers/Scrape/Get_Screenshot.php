<?php

namespace App\Helpers\Scrape;

use Spatie\Image\Manipulations;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;

class Get_Screenshot
{
    public static function screenshot_wasabi($domain)
    {
        $httpUrl = 'http://' . $domain;

        try {
            $http_request = Browsershot::url($httpUrl);

            $screenshot = $http_request->ignoreHttpsErrors()->fit(Manipulations::FIT_CONTAIN, 460, 306)->screenshot();

        } catch (\Throwable$th) {
            //throw $th;
            $screenshot = false;
        }

        if (!empty($screenshot)) {

            $thumbnail_name = $domain . '.png';
            $thumbnailPath  = '/thumbnail/' . $thumbnail_name;
            Storage::disk('wasabi')->put($thumbnailPath, $screenshot);
        } else {
            $thumbnail_name = 'noimage.png';
        }

        $favicon = "https://www.google.com/s2/favicons?domain=" . $domain;

        $favicon       = file_get_contents($favicon);
        $faviconName   = $domain . '.png';
        $faviconPath   = 'favicon/' . $faviconName;
        $faviconStatus = Storage::disk('wasabi')->put($faviconPath, $favicon);

        $result['thumbnail'] = $thumbnail_name;
        $result['favicon']   = $faviconName;
        return $result;

    }
}
