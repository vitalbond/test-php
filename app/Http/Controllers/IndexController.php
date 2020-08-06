<?php

namespace App\Http\Controllers;

use App\Models\Article;

class IndexController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('datetime', 'desc')->get();

        return view('index', [
            'articles' => $articles,
        ]);
    }
}
