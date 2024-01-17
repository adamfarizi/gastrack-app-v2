<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenarikanController extends Controller
{
    public function index()
    {
        $data['title'] = 'Penarikan';

        return view('auth.penarikan.penarikan', $data);
    }
}
