<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    public function article(int $id)
    {
        $article = Article::findOrFail($id);

        return view('article', [
            'article' => $article,
        ]);
    }
}
