<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HalamanUtama;

class HalamanUtamaController extends Controller
{
    public function index() 
    {
        return view('halamanutama.index');
    }
    public function show()
    {
        return HalamanUtama::first();
    }
    public function update(Request $request)
    {
        $halamanutama = HalamanUtama::first();
        $halamanutama -> headline = $request -> headline;
    
        $halamanutama -> update();
    
        return response()->json('Data berhasil disimpan', 200);
    }
}
