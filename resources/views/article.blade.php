@extends('layout')

@section('content')
<main class="page-article">
    <div class="jumbotron pb-4">
        <div class="container">
            <h1 class="display-4">{{ $article->title }}</h1>
            <span class="date">{{ $article->getReadableDateTime() }}</span>
            <span class="source"><span> | Источник:</span> <a href="{{ $article->source_url }}" target="_blank" class="source">{{ $article->getShortenedSourceUrl() }}</a></span>
        </div>
    </div>

    <div class="container">
        @if ($article->has_image)
            <img src="{{ $article->getImageUrl() }}" />
        @endif
        {!! $article->text !!}
        <hr>
    </div>
</main>
@endsection
