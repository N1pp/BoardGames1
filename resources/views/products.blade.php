@extends('layouts.app')
@section('content')
    <div class="container">
        <form method="GET" action="{{ route('filter') }}">
            @csrf
            <div class="form-group">
                @csrf
                Enter name:
                <textarea class="form-control" id="text" name="name"></textarea>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        Enter minimum price:
                        <input class="form-control" type="number" name="price_low">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        Enter maximum price:
                        <input class="form-control" type="number" name="price_top">
                    </div>
                </div>
            </div>
            Choose tag:
            <div class="input-group mb-3">
                <select class="custom-select" name="tag">
                    <option value="">Choose tag</option>
                    @foreach(\App\Tag::all() as $tag)
                        <option value="{{$tag->value}}">{{$tag->value}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-block" style="background: yellow">Search</button>
        </form>
    </div>
    <div style="display:flex; flex-direction: row; flex-wrap: wrap; justify-content: center">
        @if(!$products->isEmpty())
            @foreach($products as $product)
                <div class="card" style="width: 18rem; margin: 1rem; background: yellowgreen">
                            <img class="card-img-top" src="{{asset('/storage/'.$product->img)}}" alt="Card image cap">
                    <div class="card-body">
                        <div class="row" style="display: flex; flex-wrap: nowrap">
                            <div style="display:flex; flex-direction: row">
                                <h5 class="card-title">Name: {{$product->name}}</h5>
                            </div>
                            <div style="display:flex; text-align: right; flex-direction: row-reverse">
                                <p class="card-title" style="margin:0 2rem">Price: {{$product->price}}</p>
                            </div>
                        </div>
{{--                        <img class="img" style="width: 100%; max-height: 30rem"--}}
{{--                             src="{{asset('/storage/'.$product->img)}}" alt="Card image cap">--}}
                        <p class="card-text">{{$product->descriptionSmall}}</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" style="background: yellowgreen">
                            Tags:@foreach($product->tags()->get() as $tag){{$tag->value}} @endforeach</li>
                        <li class="list-group-item" style="background: yellowgreen">Amount available:{{$product->amount}}</li>
                        <li class="list-group-item" style="background: yellowgreen">Rating: {{$product->rate}}</li>
                    </ul>
                    <div class="card-body align-content-between">
                        <button class="btn btn-info" onClick='location.href="{{ route('product',[$product]) }}"'>Go to game page</button>
                    </div>
                </div>
            @endforeach
        @else <h1>No products match your request</h1>
        @endif
    </div>
@endsection
