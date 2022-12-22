<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
        $menuCount = Menu::all()->count();
        $orderCount = Order::all()->count();
        return view('index',compact('menuCount','orderCount'));
    }
}
