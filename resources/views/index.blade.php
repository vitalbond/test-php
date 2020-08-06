@extends('layout')

@section('content')
<main class="page-index">
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-3">Новости RBC.RU</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            @foreach($articles as $article)
            <div class="col-md-4">
                <h2><a href="{{ $article->link() }}">{{ $article->title }}</a></h2>
                <div class="date">{{ $article->getReadableDateTime() }}</div>
                <p>{{ $article->getShortenedText() }}</p>
                <p><a class="btn btn-secondary" href="{{ $article->link() }}" role="button">Подробнее »</a></p>
            </div>
            @endforeach
        </div>
        <hr>
    </div>
</main>
@endsection
