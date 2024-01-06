<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $data['title'] = 'Laporan';

        return view('auth.laporan.laporan', $data);
    }
}
