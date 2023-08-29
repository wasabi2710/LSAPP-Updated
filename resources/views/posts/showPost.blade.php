@extends('layouts.app')
@section('content')
<h1>{{$post->title}}</h1>
<br>
<div class="container rounded rounded-right">
    <img src="/storage/cover_images/{{$post->cover_image}}" class="img-thumbnail" alt="Profile">
</div>
<br>
<p>{{$post->body}}</p>
<br/>
<br/>
<p>{{\Carbon\Carbon::parse($post->created_at)->format('d-m-Y')}}</p>
@if (!Auth::guest())
    @if (Auth::user()->id == $post->user_id)
        <a href="/posts/{{$post->id}}/edit" class="btn btn-dark">Edit</a>
        {!!Form::open(['action' => ['App\Http\Controllers\PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
            @csrf
            @method('DELETE')
            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
        {!!Form::close()!!}
    @endif
@endif
@endsection