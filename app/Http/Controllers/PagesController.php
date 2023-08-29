<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public $pageTitle='';
    /**index page */
    public function index() {
        $title='Homepage';
        return view('pages.index')->with('title', $title);
    }
    /**about page*/
    public function about() {
        $title='About';
        return view('pages.about', compact('title'));
    }
    /**services page*/
    public function services() {
        $data = array(
            'title' => 'Services',
            'services' => ['Web Development', 'Cybersecurity', 'Python Automation']
        );
        return view('pages.services')->with($data);
    }
}
