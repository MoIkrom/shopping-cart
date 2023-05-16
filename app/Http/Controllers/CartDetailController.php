<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use Carbon\Carbon;
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
        //
    }
    /**
     * Show the form for creating a new resource.
     */
    public function checkout()
    {

        // Total Price
        $cart = Cart::whereNotNull('total')->first();
        $cart->total = 0;
        $cart->update();

        CartDetail::truncate();

        return redirect()->to('product')->with('success', 'Pesanan Berhasil di Checkout');
    }

    public function applyDiskon(Request $request)
    {
        $cartdetail = CartDetail::all();

        $cart = Cart::whereNotNull('total')->first();
        $total = $cart->total;
        $discountCode = $request->discount_code;

        switch ($discountCode) {
            case 'FA111':
                // Discount code: FA111 akan memberikan diskon 10%
                foreach ($cartdetail as $item) {
                    $item->subtotal = $item->subtotal - ($item->subtotal * 0.1);
                    $item->save();

                    // Menambahkan subtotal setelah diskon ke total
                    $total += $item->subtotal - $item->price;
                }
                break;
            case 'FA222':
                // Discount code: FA222 akan memberikan diskon 50rb untuk barang dengan kode FA4532
                $discountedProductCode = 'FA4532';
                foreach ($cartdetail as $item) {
                    if ($item->product->productcode === $discountedProductCode) {
                        $item->subtotal = $item->price - 50000;
                        $item->save();

                        // Menambahkan subtotal setelah diskon ke total
                        $total += $item->subtotal - $item->price;
                    }
                }
                break;

            case 'FA333':
                // Discount code: FA333 akan memberikan diskon 6% untuk barang di atas 400 ribu
                $minPrice = 400000;
                foreach ($cartdetail as $item) {
                    if ($item->price > $minPrice) {
                        $item->subtotal = $item->price - ($item->price * 0.06);
                        $item->save();

                        // Menambahkan subtotal setelah diskon ke total
                        $total += $item->subtotal - $item->price;
                    }
                }
                break;

            case 'FA444':
                // Discount code: FA444 akan memberikan diskon 5% jika pelanggan membeli di hari selasa jam 13:00 s/d 15:00
                $today = now();
                if ($today->dayOfWeek === Carbon::TUESDAY && $today->hour >= 13 && $today->hour <= 15) {
                    foreach ($cartdetail as $item) {
                        $item->subtotal = $item->price - ($item->price * 0.05);
                        $item->save();

                        // Menambahkan subtotal setelah diskon ke total
                        $total += $item->subtotal - $item->price;
                    }
                }
                break;

            default:
                return redirect()->back()->withErrors('Invalid discount code.');
        }

        // Update nilai total pada cart
        $cart->total = $total;
        $cart->save();

        return redirect()->back()->with('success', 'Discount applied successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $id)
    {
        $product = Product::where('id', $id)->first();

        $data = [
            'product_id' => $product->id,
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
        return view('cartDetail.index')->with(
            'data', $data
        );
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
            $cartDetail->subtotal = $data->price * $request->quantity;
            $cartDetail->save();
        } else {
            $cartDetail = CartDetail::where('product_id', $data->id)->where('cart_id', $newcart->id)->first();
            $cartDetail->quantity = $cartDetail->quantity + $request->quantity;

            // new Price
            $New_price_cartDetail = $data->price * $request->quantity;
            $cartDetail->subtotal = $cartDetail->subtotal + $New_price_cartDetail;
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
        $cart->total = $cart->total - $cartdetail->subtotal;
        $cart->update();

        // update stock
        $product_id = $cartdetail->product_id;
        $product = Product::find($product_id);

        if ($product) {
            $product->stock += $cartdetail->quantity;
            $product->update();
        }

        CartDetail::where('id', $id)->delete();

        return redirect()->to('cart')->with('success', 'Pesanan Berhasil di Hapus');
    }
}
