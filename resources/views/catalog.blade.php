@extends('layouts.app')
@section('content')
    <div style="display:flex; flex-direction: row; flex-wrap: wrap;">
        @foreach($products as $product)
            <div class="card" style="width: 18rem">
                <div class="card-body">
                    <h1 class="card-title"><a href="/product/{{$product->id}}">{{$product->name}}</a></h1>
                </div>
            </div>
        @endforeach
    </div>
@endsection
