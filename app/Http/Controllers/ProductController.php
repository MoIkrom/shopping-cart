<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $Baris = 3;

        if (strlen($katakunci)) {
            $data = Product::where('productname', 'like', "%$katakunci%")
                ->orWhere('productcode', 'like', "%$katakunci%")
                ->paginate($Baris);
        } else {

            $data = Product::orderBy('created_at', 'desc')->paginate($Baris);
        }
        return view('product.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->session()->flash('productname', $request->productname);
        $request->session()->flash('productcode', $request->productcode);
        $request->session()->flash('price', $request->price);
        $request->session()->flash('stock', $request->stock);

        $request->validate([
            'productname' => 'required|unique:products,productname',
            'productcode' => 'required|unique:products,productcode',
            'price' => 'required',
            'stock' => 'required',

        ], [
            'productname.required' => 'Nama Produk harus di isi',
            'productname.unique' => 'Nama Produk sudah ada',
            'productcode.required' => 'Kode Produk harus di isi',
            'productcode.unique' => 'Kode Produk sudah ada',
            'price.required' => 'Harga Produk harus di isi',
            'stock.required' => 'Stock Produk harus di isi',
        ]);

        $data = [
            'productname' => $request->productname,
            'productcode' => $request->productcode,
            'price' => $request->price,
            'stock' => $request->stock,
        ];
        Product::create($data);

        return redirect()->to('product')->with('success', 'Data Berhasil ditambahkan');
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
        $data = Product::where('id', $id)->first();
        return view('product.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'productname' => 'required',
            'productcode' => 'required',
            'price' => 'required',
            'stock' => 'required',

        ], [
            'productname.required' => 'Nama Produk harus di isi',
            'productcode.required' => 'Kode Produk harus di isi',
            'price.required' => 'Harga Produk harus di isi',
            'stock.required' => 'Stock Produk harus di isi',
        ]);

        $data = [
            'productname' => $request->productname,
            'productcode' => $request->productcode,
            'price' => $request->price,
            'stock' => $request->stock,
        ];
        Product::where('id', $id)->update($data);

        return redirect()->to('product')->with('success', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::where('id', $id)->delete();

        return redirect()->to('product')->with('success', 'Data Berhasil di Hapus');
    }
}
