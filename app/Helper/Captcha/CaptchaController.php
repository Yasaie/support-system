<?php

namespace App\Helper\Captcha;

use App\Helper\Captcha\Facades\Captcha;
use App\Http\Controllers\Controller;

class CaptchaController extends Controller
{
    /**
     * Get image.
     *
     * @return mixed
     */
    public function image()
    {
        $image = Captcha::getImage();

        return response($image)->header('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate')
            ->header('Cache-Control', 'post-check=0, pre-check=0', false)
            ->header('Pragma', 'no-cache')
            ->header('Content-Type', 'image/png');
    }
}
