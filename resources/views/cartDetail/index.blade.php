
@extends('layout.template')

@section('content')

<div class="container">
    <div class="d-flex align-items-center justify-content-center my-3 mt-5 p-5 bg-body rounded shadow-sm">
        <div class="col-6">
            <h3 class="text-center text-decoration-underline">{{$data->productname}}</h3>
            <table class="table mt-5">
                <tbody>
                    <tr>
                        <td>Kode Product </td>
                        <td> :</td>
                        <td> {{$data->productcode}}</td>
                    </tr>
                    <tr>
                        <td>Harga</td>
                        <td>:</td>
                        <td>Rp {{number_format(floatval($data->price), 0, ',', '.')}}</td>
                    </tr>
                    <tr>
                        <td>Stock</td>
                        <td>:</td>
                        <td> {{$data->stock}}</td>
                    </tr>
                    
                        <tr class="border-white"> 
                            <td>Jumlah Pesanan</td>
                            <td>:</td>
                            <td> 
                            <form action="{{url('cart-detail')}}/{{$data->id}}" method="POST">
                                @method('PATCH')
                                @csrf
                                <input type="text" name="quantity" class="form-control" required> 
                                <button class="btn btn-success mt-3">Masukkan ke Troli</button>
                            </form>
                        </td>
                        </tr>
                </tbody>
            </table>
       
        </div>

  
  
   
     
    </div>
   

</div>

@endsection