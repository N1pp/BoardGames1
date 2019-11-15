@extends('layouts.app')
@section('content')
    @foreach($products as $product)
        <h1><a href="/product/{{$product->id}}">{{$product->name}}</a></h1>
    @endforeach
@endsection
