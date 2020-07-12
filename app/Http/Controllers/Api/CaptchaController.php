<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Mews\Captcha\Facades\Captcha;

class CaptchaController extends Controller
{
    //
    public function index($type = 1)
    {


        switch ($type) {

            case 'min':

                return Captcha::create('mini');
                break;
            case 'math':

                return Captcha::create('math');
                break;
            case 'flat':

                return Captcha::create('flat');
                break;
            case 'inverse':
                return Captcha::create('inverse');
                break;
            case 'admin':

                return Captcha::create('admin');
                break;
            default:
                return Captcha::create();
                break;
        }

    }
}
