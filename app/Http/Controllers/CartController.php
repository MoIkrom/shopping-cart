<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $katakunci = $request->katakunci;
        $Baris = 10;

        // if (strlen($katakunci)) {
        //     $data = Cart::where('productname', 'like', "%$katakunci%")
        //         ->orWhere('productcode', 'like', "%$katakunci%")
        //         ->paginate($Baris);
        // } else {

        $data = CartDetail::orderBy('created_at', 'desc')->paginate($Baris);
        $cart = Cart::orderBy('created_at', 'desc')->get();
        // }
        return view('cart.index')->with('data', $data)->with('cart', $cart);
        // return "Hello ini Cart";
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->to('product')->with('success', 'Data Berhasil ditambahkan');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $product = Product::where('id', $id)->first();

        // // Create Cart

        // // $cart = new Cart;
        // // $cart->total = $product->price * 2;
        // // $cart->save();
        // // // Create Cart Detail
        // // $newCart = Cart::where('id', $id)->first();
        // // $cartDetail = new CartDetail;
        // // $cartDetail->product_id = $product->id;
        // // $cartDetail->product_id = $newCart->id;
        // // $cartDetail->quantity = 2;
        // // $cartDetail->price = $product->price * 2;
        // // $cartDetail->save();

        $data = [
            'total' => $product->price,
            // //     // 'quantity' => $request->productcode,
            // //     // 'subtotal' => $request->price,
        ];
        Cart::create($data);

        // $data = [
        //     'total' => $product->price * 2,
        // ];
        // Cart::create($data);
        return redirect()->to('product')->with('success', 'Product Berhasil ditambahkan ke Troli');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
