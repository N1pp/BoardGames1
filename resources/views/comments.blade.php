@extends('layouts.app')
@section('content')
    <button class="btn btn-info" onClick='location.href="{{ route('createProductForm') }}"'>Create new product</button>
    <button class="btn btn-info" onClick='location.href="{{ route('showProductStatistics') }}"'>Show Statistics</button>
    <button class="btn btn-info" onClick='location.href="{{ route('admin') }}"'>Show Products</button>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>User name</th>
            <th>Product ID</th>
            <th>Product name</th>
            <th>Value</th>
        </tr>
        </thead>
        <tbody>
        @foreach($comments as $comment)
            <tr>
                <th scope="row">{{$comment->id}}</th>
                <td>{{$comment->user_id}}</td>
                <td>{{\App\User::find($comment->user_id)->name}}</td>
                <td>{{$comment->product_id}}</td>
                <td>{{\App\Product::find($comment->product_id)->name}}</td>
                <td>{{$comment->value}}</td>
                <td>
                    <form action="{{ route('deleteComment') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{$comment->id}}" name="id">
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
