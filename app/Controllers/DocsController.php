<?php

namespace App\Controllers;

use Gobel\Http\Request;

class DocsController
{
    /**
     * Show the framework documentation.
     *
     * @return \Gobel\Http\Response
     */
    public function index()
    {
        return view('docs');
    }
}
