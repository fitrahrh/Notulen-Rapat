<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $reports = Report::count();

        return view('dashboard.index', [
            'title' => 'Dashboard',
            'reports' => $reports,
            'user' => $request->user(),
        ]);
    }
}