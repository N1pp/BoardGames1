@extends('layouts.app')
@section('content')
    <button class="btn btn-info" onClick='location.href="{{ route('createProductForm') }}"'>Create new product</button>
    <button class="btn btn-info" onClick='location.href="{{ route('showComments') }}"'>Show comments</button>
    <button class="btn btn-info" onClick='location.href="{{ route('admin') }}"'>Show Products</button></br>
    Most purchased product
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>id</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">{{$maxSalesProduct->name}}</th>
            <td>{{$maxSales}}</td>
        </tr>
        </tbody>
    </table>
    Most ratable products
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>id</th>
            <th>rate</th>
        </tr>
        </thead>
        <tbody>
        @foreach($maxRated as $maxRate)
            <tr>
                <th scope="row">{{$maxRate->name}}</th>
                <td>{{$maxRate->rate}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Total sales this month</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">{{$totalSales}}</th>
        </tr>
        </tbody>
    </table>
@endsection
