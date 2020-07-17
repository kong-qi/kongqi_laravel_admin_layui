<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function index(){
        return $this->display();
    }
    public function home(){
        return $this->display();
    }
    public function map($type,Request $request){
        $this->setViewPath($type.'Map');
        return $this->display();
    }
}
