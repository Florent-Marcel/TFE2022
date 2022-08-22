<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WebsiteLangController extends Controller
{
    /**
     * Set the current language
     */
    public function change($lang)
    {
        if(!isset($lang)){
            throw new HttpException(400, "the parameters are incorrect");
        }

        if($lang != 'fr' && $lang != 'en'){
            throw new HttpException(400, "the parameters are incorrect");
        }

        App::setLocale($lang);
        session()->put('locale', $lang);
        return redirect()->back();
    }
}
