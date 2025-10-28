<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the ReStylo landing page.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Landing');
    }
}
