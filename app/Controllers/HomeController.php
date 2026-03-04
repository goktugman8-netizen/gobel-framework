<?php

namespace App\Controllers;

use Gobel\Http\Request;
use Gobel\Http\Response;

class HomeController
{
    /**
     * Display the home page.
     *
     * @return Response|string
     */
    public function index()
    {
        return view('welcome', ['framework' => 'Gobel Advanced']);
    }

    /**
     * Display the about page.
     *
     * @return Response|string
     */
    public function about()
    {
        return view('about');
    }
}
