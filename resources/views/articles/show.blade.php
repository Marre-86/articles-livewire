@extends('layouts.main')
@section('content')
    <div>
        <div class="card border-primary mb-3" style="max-width:30rem; float:left; margin-top:2rem">
            <div class="card-header">ID #{{ $article->id }}</div>
            <div class="card-body">
                <p class="card-text"><b>Name: </b>
                    {{ $article->name }}</p>
                <p class="card-text"><b>Category: </b>
                    {{ $article->category->name }}</p>
                <p class="card-text"><b>Content: </b>
                    {{ $article->content }}</p>
                <p class="card-text"><span style="color:#495057"><b>Creation Date: </b></span>
                    {{ $article->created_at }}</p>
                <p class="card-text"><span style="color:#495057"><b>Update Date: </b></span>
                    {{ $article->updated_at }}</p>
            </div>
        </div>
        <div class="card" style="width: 30rem;  float:left; margin:2rem 0 0 1rem;">
            <div class="card-body">
                <img src="{{ asset('storage/images/'.$article->image) }}" class="img-card">
            </div>
        </div>
    </div>
@endsection