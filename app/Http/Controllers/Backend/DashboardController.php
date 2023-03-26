<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {

        $count1 = 0;
        $count2 = 0;
        $count3 = 0;
        $count4 = 0;
        $count5 = 0;
        $count6 = 0;
        $count7 = 0;
        return view('backend.pages.dashboard', compact('count1', 'count2', 'count3', 'count4', 'count5', 'count6', 'count7'));
    }
}
