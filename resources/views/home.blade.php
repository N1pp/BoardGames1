@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="background: yellowgreen">
                    <div class="card-header">Your actions</div>
                    <div class="card-body">
                        <div>
                            @if(\Illuminate\Support\Facades\Auth::user()->email_verified_at == null)
                                Для покупки товаров подтвердите вашу почту
                            @endif
                        </div>
                        <div>
                            Your favourites:
                        </div>
                        <ul>
                            @foreach($favourites as $product)
                                <li>
                                    <div class="row">
                                        <div class="col-auto">
                                            Name: <a href="{{route('product',[$product])}}">{{$product->name}}</a>
                                        </div>
                                        <div class="col-auto">
                                            Price: {{$product->price}}
                                        </div>
                                        <form action="{{route('manageFavourites')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <button class="btn btn-danger btn-sm col-auto" name="value" value="-1"
                                                    type="submit">Remove favourites
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @isset($sales)
                            Your sales:
                            <ul>
                                @foreach($sales as $sale)
                                    <li>
                                        <div class="row">
                                            <div class="col-auto">Sale number: {{$sale->id}} </div>
                                            <div class="col-auto">Total price {{$sale->price}} </div>
                                        </div>
                                        Order list:
                                        @foreach(\App\ProductSales::all()->where('sales_id',$sale->id) as $connection)
                                            <ul><a href="{{route('product',[\App\Product::find($connection->product_id)])}}">{{\App\Product::find($connection->product_id)->name}}</a></ul>
                                        @endforeach
                                    </li>
                                @endforeach
                            </ul>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
