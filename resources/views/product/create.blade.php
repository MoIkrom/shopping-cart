@extends('layout.template')
  

@section('content')



  <!-- START FORM -->
   <form action='{{url('product')}}' method='post'>
@csrf

    <div class="my-3 mt-5 p-5 bg-body rounded shadow-sm">
        <h3 class="text-center">Buat Product Baru</h3>
        <div class="p-5">   <div class="mb-3 row">
            <label for="productname" class="col-sm-2 col-form-label">Nama Product</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='productname' id="productname" value="{{Session::get('productname')}}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="productcode" class="col-sm-2 col-form-label">Kode Product</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='productcode' id="productcode" value="{{Session::get('productcode')}}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="price" class="col-sm-2 col-form-label">Harga</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='price' id="price" value="{{Session::get('price')}}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="stock" class="col-sm-2 col-form-label">Stock</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='stock' id="stock" value="{{Session::get('stock')}}">
            </div>
        </div></div>
     
        <div class="d-flex justify-content-center mb-3">
            <div class="d-flex justify-content-between col-sm-10"><button type="submit" class="btn btn-primary" name="submit">SIMPAN</button>   <a href="{{url('product')}}" class="btn btn-secondary">Kembali</a></div>
        </div>
    </div>
</form>
    <!-- AKHIR FORM -->

    @endsection