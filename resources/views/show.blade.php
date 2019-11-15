@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="border-bottom border-dark">
            <div class="row justify-content-md-center">
                <div class="col-lg-10">
                    <h1>Title: {{$product->name}}</h1>
                </div>
                <div class="col-2">
                    Price: {{$product->price}}
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    Tags:
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    Rating:{{$product->rate}}
                </div>
                <div class="col-11">
                    {{$product->description}}
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    Date:{{$product->created_at}}
                </div>
            </div>
    </div>
@endsection
