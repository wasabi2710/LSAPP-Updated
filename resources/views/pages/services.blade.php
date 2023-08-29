@extends('layouts.app')
@section('content')
    <h1>{{$title}}</h1>
    @if (count($services) >0)
        @foreach ($services as $service)
        <ul class="list-group">
            @if ($service == "Github")
                <li class="list-group-item"><a href="https://github.com/wasabi2710" target="_blank">{{$service}}</a></li>
            @else
                <li class="list-group-item">{{$service}}</li>
            @endif
        </ul>
        @endforeach
    @endif
@endsection