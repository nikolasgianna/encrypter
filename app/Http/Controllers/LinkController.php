<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Link;

class LinkController extends Controller
{
    public function create()
    {
      return view('create');
    }

    public function store()
    {

      $link = new Link();

      $link->title = request('title');
      $link->description = request('description');
      $link->url = request('url');
      $link->save();
      return redirect('/');
    }


}
