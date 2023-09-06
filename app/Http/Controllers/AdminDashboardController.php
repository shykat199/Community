<?php

namespace App\Http\Controllers;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {

        return view('admin.layouts.master');
    }

}
