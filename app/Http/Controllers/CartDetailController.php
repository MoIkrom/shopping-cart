<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class CartDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return redirect()->to('product')->with('success', 'Product Berhasil ditambahkan ke Keranjang');
        return view('cartDetail.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $id)
    {
        $product = Product::where('id', $id)->first();

        // $cart = new Cart;
        // $cart->total = 0;
        // $cart->save();

        $data = [
            'product_id' => $product->id,
            // 'cart_id' => $request->productcode,
            'quantity' => 0,
            'price' => $product->price,
        ];
        CartDetail::create($data);

        return redirect()->to('product')->with('success', 'Data Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Product::where('id', $id)->first();
        return view('cartDetail.index')->with('data', $data);
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
        $data = Product::where('id', $id)->first();

        // validation stock
        if ($request->quantity > $data->stock) {
            return redirect()->to('cart-detail/' . $data->id)->with('failed', 'Stock Product Tidak Cukup');
        }

        // validation check
        $check_cart = Cart::whereNotNull('total')->first();
        // Save ke DB table Cart
        if (empty($check_cart)) {
            $cart = new Cart;
            $cart->total = 0;
            $cart->save();
        }

        // new Cart
        $newcart = Cart::whereNotNull('total')->first();

        // Validation duplicate
        $check_CartDetail = CartDetail::where('product_id', $data->id)->where('cart_id', $newcart->id)->first();
        if (empty($check_CartDetail)) {
            // Save ke DB table Cart Detail
            $cartDetail = new CartDetail;
            $cartDetail->product_id = $data->id;
            $cartDetail->cart_id = $newcart->id;
            $cartDetail->quantity = $request->quantity;
            $cartDetail->price = $data->price;
            $cartDetail->total = $data->price * $request->quantity;
            $cartDetail->save();
        } else {
            $cartDetail = CartDetail::where('product_id', $data->id)->where('cart_id', $newcart->id)->first();
            $cartDetail->quantity = $cartDetail->quantity + $request->quantity;

            // new Price
            $New_price_cartDetail = $data->price * $request->quantity;
            $cartDetail->total = $cartDetail->total + $New_price_cartDetail;
            $cartDetail->update();
        }

        // Total Price
        $cart = Cart::whereNotNull('total')->first();
        $cart->total = $cart->total + $data->price * $request->quantity;
        $cart->update();

        // Update Stock
        $product = Product::where('id', $id)->first();
        $product->stock = $product->stock - $request->quantity;
        $product->update();

        return redirect()->to('product')->with('success', 'Product Berhasil di Masukkan ke Troli');

    }

/**
 * Remove the specified resource from storage.
 */
    public function destroy(string $id)
    {

        $cartdetail = CartDetail::where('id', $id)->first();

        // Total Price
        $cart = Cart::whereNotNull('total')->first();
        $cart->total = $cart->total - $cartdetail->total;
        $cart->update();

        CartDetail::where('id', $id)->delete();

        return redirect()->to('cart')->with('success', 'Pesanan Berhasil di Hapus');
    }
}
