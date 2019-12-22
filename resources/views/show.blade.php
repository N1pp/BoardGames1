@extends('layouts.app')
@section('content')
    <div class="container border border-success" style="background: yellowgreen; border-radius: 10px">
        <div class="border-dark">
            <div class="row justify-content-md-center">
                <div class="col-lg-10">
                    <h1>Title: {{$product->name}}</h1>
                </div>
                <div class="col-auto">
                    @if($product->amount > 0 )
                        Amount: {{$product->amount}}
                        Price: {{$product->price}}
                    @else
                        Sold out!
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-9">
                    Rating: {{$product->rate}}
                </div>
                <div class="col-1">
                    @if($product->amount > 0 )
                        <form action="{{route('buyProduct')}}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <button class="btn" type="submit">Купить</button>
                        </form>
                    @endif
                </div>
                @if(!\App\Favourites::where('user_id',\Illuminate\Support\Facades\Auth::id())->where('product_id',$product->id)->get()->first())
                    <div class="col-2">
                        <form action="{{route('manageFavourites')}}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <button class="btn btn-success" name="value" value="1" type="submit">Add to favourites
                            </button>
                        </form>
                    </div>
                @else
                    <div class="col-2">
                        <form action="{{route('manageFavourites')}}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <button class="btn btn-danger" name="value" value="-1" type="submit">Remove favourites
                            </button>
                        </form>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-1">
                    Comments:{{$product->comment}}
                </div>
                <div class="col-11">
                    {{$product->description}}
                </div>
                <div>
                    <form action="{{route('makeRate')}}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <button class="btn btn-sm btn-success" name="value" value="1" type="submit">Like</button>
                    </form>
                    <form action="{{route('makeRate')}}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <button class="btn btn-sm btn-danger" name="value" value="-1" type="submit">Dislike</button>
                    </form>
                </div>
            </div>
            <div class="row">
                Tags: @foreach($product->tags()->get() as $tag)
                    {{$tag->value}}
                @endforeach
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
                    <button class="btn btn-block" type="submit">Leave</button>
                </form>
                @foreach(\App\Comment::where('product_id',$product->id)->get() as $comment)
                    <div class="container border border-dark" style="border-radius: 10px">
                        <div class="row">
                            <div class="col-auto">Autor: {{\App\User::find($comment->user_id)->name}}</div>
                        </div>
                        <div class="col col-md-11 ml-auto">{{$comment->value}}</div>
                        <div class="row">
                            <div class="col-auto">{{$comment->created_at}}</div>
                        </div>
                    </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
