
    @extends('layout.template')

        
    @section('content')

  
    
    <!-- START DATA -->
    <div class="my-3 p-5 bg-body rounded shadow-sm">
       
        <div class="d-flex justify-content-between">

                <!-- FORM PENCARIAN -->
                <div class="col-5 pb-3">
                  <form class="d-flex" action="{{url('product')}}" method="get">
                      <input class="form-control me-1" type="search" name="katakunci" value="{{ Request::get('katakunci') }}" placeholder="Masukkan kata kunci" aria-label="Search">
                      <button class="btn btn-secondary" type="submit">Cari</button>
                  </form>
                </div>
                
                <!-- TOMBOL TAMBAH DATA -->
                <div class="pb-3">
                  <a href='{{url('product/create')}}' class="btn btn-primary">+ Tambah Data</a>
                </div>
        </div>
          <hr>
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th class="col-md-1">No</th>
                            <th class="col-md-3">Nama Produk</th>
                            <th class="col-md-4">Kode Produk</th>
                            <th class="col-md-2">Harga</th>
                            <th class="col-md-2">Stock</th>
                            <th class="col-md-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i =$data->firstItem() ?>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$item->productname}}</td>
                            <td>{{$item->productcode}}</td>
                            <td>Rp {{number_format(floatval($item->price), 0, ',', '.')}}</td>
                            <td>{{$item->stock}}</td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center gap-2">

                                    
                                    <a href='{{url('cart-detail')}}/{{$item->id}}' class="btn btn-success btn-sm">Buy</a>
                                    {{-- <form action="{{ url('cart-detail/'.$item->id)}}">  @csrf --}}
                                    
                                    {{-- <form action="{{ route('cart.store')}}" method="POST">  @csrf --}}
                                        {{-- <button class="btn btn-success btn-sm" type="submit" name="submit">Buy</button> --}}
                                    {{-- </form> --}}
                                    <form onsubmit="return confirm('Anda Yakin Ingin Menghapus Product ini')" action="{{url('product/'.$item->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit" name="submit">Del</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php $i++ ?>
                        @endforeach
                    </tbody>
                </table>
               {{$data->withQueryString()->links()}}
    </div>
          <!-- AKHIR DATA -->
    @endsection