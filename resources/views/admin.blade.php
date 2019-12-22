@extends('layouts.app')
@section('content')
    <button class="btn btn-info" onClick='location.href="{{ route('createProductForm') }}"'>Create new product</button>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>id</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <th scope="row">{{$product->id}}</th>
                <td>{{$product->name}}</td>
                <td>{{$product->description}}</td>
                <td>{{$product->price}}</td>
                <td>{{$product->amount}}</td>
                <td>
                    <form action="{{ route('addAmount') }}" method="POST">
                        @csrf
                        <input type="number" name="amount" min="1">
                        <input type="hidden" value="{{$product->id}}" name="id">
                        <button class="btn btn-info">Add to amount</button>
                    </form></td>
                <td>
                    <form action="{{ route('editProductForm') }}" method="GET">
                        @csrf
                        <input type="hidden" value="{{$product->id}}" name="id">
                        <button class="btn btn-info">Edit</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('deleteProduct') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{$product->id}}" name="id">
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
