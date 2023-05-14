
@extends('layout.template')

        
@section('content')

<!-- START DATA -->
<div class="my-3 p-5 bg-body rounded shadow-sm">
   
<h3 class="text-center mb-5">Troli Anda</h3>
      <hr>
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="col-md-1"><h4>
                          No
                          </h3>
                        </th>
                        <th class="col-md-3"><h5>PRODUCT</h5></th>
                        <th class="col-md-4"><h5>HARGA PRODUCT</h5></th>
                        <th class="col-md-2"><h5>KUANTITAS</h5></th>
                        <th class="col-md-2"><h5>SUBTOTAL</h5></th>
                        <th class="col-md-2"><h5>HAPUS</h5></th>
                    </tr>
                </thead>
                <tbody>
                  <?php $no = 1; ?>
                  @foreach ($data as $item)
                  <tr>
                      <td>{{$no}}</td>
                      <td>
                        <div class="d-flex flex-column">
                          <p class="text-primary fw-bold m-0" style="font-size: 17px">
                            {{$item->product->productname}}
                          </p>
                              <p class="text-secondary m-0" style="font-size: 12px">
                                {{$item->product->productcode}}
                              </p>
                        </div>
                      </td>
                     
                      <td  class="text-dark fw-bold ">Rp {{number_format(floatval($item->product->price), 0, ',', '.')}}</td>
                      <td  class="text-dark fw-bold ">
                        <div class="d-flex justify-content-center">
                          <input type="number" class="form-control border-0 bg-transparent w-50  outline-none text-center" value={{$item->quantity}}>
                        </div>
                      </td>
                      <td  class="text-dark fw-bold ">Rp {{number_format(floatval($item->total), 0, ',', '.')}}</td>
                      <td  class="text-dark fw-bold ">   
                        
                        <form onsubmit="return confirm('Anda Yakin Ingin Menghapus Product ini')" action="{{url('cart-detail/'.$item->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit" name="submit">Del</button>
                    </form></td>
                
                  </tr>
                  <?php $no++ ?>
                  @endforeach
                  @foreach ($data as $item)
                  <tr >
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-dark fw-bold " style="font-size: 20px">TOTAL</td>
                    <td class="text-dark fw-bold " style="font-size: 20px"> Rp {{number_format(floatval($item->total), 0, ',', '.')}}</td>
                    <td></td>
                  </tr>
                  @endforeach
              
                </tbody>
         
            </table>
            {{$data->withQueryString()->links()}}
</div>
      <!-- AKHIR DATA -->
@endsection