<?php

namespace App\Http\Controllers;

use App\Product;
use App\Sale;
use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $favourites = User::find(Auth::id())->favourites->map(function ($item) {
            return $item->product_id;
        });
        $products = [];
        foreach ($favourites as $id) {
            $products[] = Product::find($id);
        }
        $sales = Sale::where('user_id',Auth::id())->get();
        return view('home', [
            'favourites' => $products,
            'sales'      => $sales
        ]);
    }
}
