<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    // Setelah login, redirect sesuai role
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('warga.dashboard');
    }

    // Dashboard Admin
    public function adminIndex()
    {
        return view('pages.admin.index');
    }

    // Dashboard Warga
    public function wargaIndex()
    {
        return view('pages.warga.index');
    }
}