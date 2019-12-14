@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        <div>
                            @if(\Illuminate\Support\Facades\Auth::user()->email_verified_at == null)
                                Для покупки товаров подтвердите вашу почту
                            @endif
                        </div>
                        <div>
                            @isset($favourites)
                                Your favourites:
                        </div>
                        <ul>
                            @foreach($favourites as $product)
                                <li><a href="{{route('product',[$product])}}">{{$product->name}}</a></li>
                            @endforeach
                        </ul>
                        @endisset
                        @isset($sales)
                            Your sales:
                            <ul>
                                @foreach($sales as $sale)
                                    <li><a href="">{{$sale->id}}</a>
                                        {{--                                        {{$sale->products()->first()->name}}--}}
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
