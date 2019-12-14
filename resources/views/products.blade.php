@extends('layouts.app')
@section('content')
    <div style="display:flex; flex-direction: row; flex-wrap: wrap; justify-content: center ">
        @foreach($products as $product)
            <div class="card" style="width: 18rem; margin: 1rem">
                {{--        <img class="card-img-top" src=".../100px180/?text=Image cap" alt="Card image cap">--}}
                <div class="card-body">
                    <div style="display: flex; flex-wrap: nowrap">
                        <div style="display:flex; flex-direction: row">
                            <h5 class="card-title">{{$product->name}}</h5>
                        </div>
                        <div style="display:flex; flex-direction: row-reverse">
                            <p class="card-title" style="margin:0 2rem">{{$product->price   }}</p>
                        </div>
                    </div>
                    <p class="card-text">{{$product->description}}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        Tags:@foreach($product->tags()->get() as $tag){{$tag->value}} @endforeach</li>
                    <li class="list-group-item">Amount of comments:{{$product->comment}}</li>
                    <li class="list-group-item">Rating: {{$product->rate}}</li>
                </ul>
                <div class="card-body">
                    <a href="{{ route('product',[$product]) }}" class="card-link">Go to game page</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
