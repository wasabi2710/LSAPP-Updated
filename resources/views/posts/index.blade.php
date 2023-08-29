@extends('layouts.app')
@section('content')
    
    <h1>Posts</h1>
    @if (count($posts) > 0)
        @foreach ($posts as $post)
            <div class="well p-2 mb-2 border rounded">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img src="/storage/cover_images/{{$post->cover_image}}" class="img-fluid img-thumbnail" alt="Profile">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a class="link" href="/posts/{{$post->id}}">{{ $post->title }}</a></h3>
                        <p>Written On {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</p>
                        <p>Author {{$post->user->name}}</p>
                    </div>
                </div>
            </div>
        @endforeach
        <p>{{$posts->links()}}</p>
    @else
        <h3>No Posts ...</h3>
    @endif

@endsection