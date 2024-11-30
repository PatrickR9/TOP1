<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BibleController extends Controller
{
    public function index()
    {
        $viewParams =
        [
            'title' => 'Bibelstellen'
        ];

        return view('management.bible.index', $viewParams);
    }
}
