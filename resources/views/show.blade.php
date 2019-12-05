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
                    {{$product->tags()}}
{{--                    @foreach(\App\Tag::where('product_id',$product->id)->get() as $tag)--}}
{{--                        {{$tag->value . ' '}}--}}
{{--                    @endforeach--}}
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    Comments:{{$product->comment}}
                </div>
                <form action="{{route('makeRate')}}" method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <button class="btn-success" name="value" value="1" type="submit">Like</button>
                </form>
                <form action="{{route('makeRate')}}" method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <button class="btn-danger" name="value" value="1" type="submit">Dislike</button>
                </form>
                <div class="col-11">
                    {{$product->description}}
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    Date:{{$product->created_at}}
                </div>
            </div>
            <div>
                Leave a comment:
                <form action="/leaveComment" method="post">
                    @csrf
                    <textarea class="form-control" name="value">
                    </textarea>
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <input type="submit">
                </form>
                @foreach(\App\Comment::where('product_id',$product->id)->get() as $comment)
                    <div>{{$comment->value}}</div>
                @endforeach
            </div>
    </div>
@endsection
