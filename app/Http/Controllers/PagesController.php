<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Pages;

class PagesController extends Controller
{
    public function pages(Request $req)
    {

        $slug = $req->slug;
        $data = Pages::where('slug', $slug)->first();
        return view('pages.pages', compact('data'));
    }
}
