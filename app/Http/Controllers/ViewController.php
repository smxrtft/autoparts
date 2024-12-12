<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function about()
    {
        return view("info.about");
    }
    public function contacts()
    {
        return view("info.contacts");
    }
    public function delivery()
    {
        return view("info.delivery");
    }
}
