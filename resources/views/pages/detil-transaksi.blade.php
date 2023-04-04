@extends('templates.master')
@section('content')

    <div class="container-fluid mt-5">
        <div class="mb-5">
            <div class="row">
                       
                @php 
                    $status_invoice = \App\Transaction::where('id_transaction',  $no_transaksi)
                    ->first('status');
                    @endphp 
                    @if ($status_invoice->status==0)
                <div class="col-lg-8 col-md-6 col-sm-6 col-12 list-receipt">
                                <div class="row mt-3 justify-content-center">
                                    <div class="col-md-12 text-center">
                                        <h4 class="nunito" style="text-transform: uppercase">Silahkan lakukan pembayaran <br> ke No Rek berikut </h4>
                                        {{-- <img src="{{ asset('images/payment.svg') }}" class="img-fluid mt-5" alt=""> --}}
                                        <hr>
                                    </div>
                                    <div class="col"></div>
                                    <div class="col-12 demo-content mb-5">

                                      <div class="text-center">
                                          
                                          @foreach ($bank as $b)
                                        <input type="text" value="{{$b->no_akun}}" id="myInput" hidden>
                                        <h3 class="mb-0 bolder">{{$b->nama_bank}}</h3>
                                        <h3 class="mb-0 bolder ml-5">{{$b->no_akun}}   <button class="btn-copy" onclick="myFunction()"><i class="fa fa-copy"></i></button></h3>
                                        <p class="size-18 nunito">{{$b->nama_akun}}</p>
                                        <hr>
                                        <p class="size-18 nunito mt-5">TOTAL</p>
                                        <h1 class="bolder nunito" style="color:#158422">
                                            Rp. {{number_format($trans->total_bayar)}}
                                          
                                        </h1>
                                    @endforeach
                                      </div>
                                    </div>
                                    <div class="col"></div>
                                   
                                            {{-- <table border=0 cellpadding=5 cellspacing=1> 
                                    
                                                <tr><td>Nama Bank</td><td> : </td><td> {{$b->nama_bank}}</td></tr>
                                                <tr><td>No Rekening</td><td> : </td><td> {{$b->no_akun}}</td></tr>
                                                <tr><td>Pemilik Rekening</td><td> : </td><td> {{$b->nama_akun}}</td></tr>
                                                <tr><td>Nominal Yang ditransfer</td><td> : </td><td class="text-danger"> </td></tr>
                                            </table> --}}
                                       
                                    </div>
                               
                                </div>
                                @else
                                <div class="col-lg-8 col-md-6 col-sm-6 col-12 list-receipt">
                                    <div class="col-md-12 text-center">
                                        <h4 class="nunito" style="text-transform: uppercase">No Transaksi <b>{{ $no_transaksi }}</b></h4>
                                        <h4 class="nunito bolder mt-5 w-100 ">Alamat Pengiriman</h4>
                                        {{-- <img src="{{ asset('images/payment.svg') }}" class="img-fluid mt-5" alt=""> --}}
                                        <hr>
                                    </div>
                                   <div class="col"></div>
                                        <div class="col-12 demo-content mb-5">

                                            <div class="text-center">
                                                <div class="row mb-5">
                                                    <div class="col-md-12">
                                                        <div class="ml-2 p-3 size-16">
                                                            <span class="nunito semi-bolder size-20">{{ $address->name }}</span> <br> (0{{ substr($address->phone, 2, 12) }})<br>
                                                            <br>
                                                            {{ $address->address }} <br>
                                                            Kecamatan {{ $address->kecamatan->subdistrict_name }}<br>
                                                            {{ $address->kota->type }} {{ $address->kota->city_name }}<br>
                                                            {{ $address->kota->postal_code }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="col"></div>
                                </div>
                                @endif
                
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 receipt mt-2">
                            <div class="container">
                     
                                <div class="receipt_box">
                                    <div class="head">
                                        <div class="logo">
                                          <img src="{{ asset('images/logo.png')}}" style="width:100px" alt="">
                                        </div>
                                        <div class="number">
                                            <div class="date">{{ date('d-m-Y') }}</div>
                                            <div class="ref">{{$no_transaksi}}</div>
                                        </div>
                                   
                                    </div>
                                    @php 
                                    $countbuy=0;
                                    @endphp
                                    @foreach ( $data as $d )
                                    @php 
                                    $countbuy++;
                                    @endphp
                                    @endforeach
                                    <div class="body mb-0">
                                        <div class="info">
                                            <div class="welcome mb-0">Hi, <span class="username">{{ session('user-session')->name }}</span></div>
                                            <p>Kamu membeli Total <b>({{$countbuy}})</b> barang</p>
                                        </div>
                                        <div class="cart">
                                            <div class="title mb-0">Rincian</div>
                                            <div class="content">       
                                                <ul class="cart_list">
                                                    @php 
                                                    $countbuy=0;
                                                      @endphp
                                                    @foreach ( $data as $d )
                                                        @php 
                                                        $countbuy++;
                                                        @endphp
                                                    @if ($d->id_user == session('user-session')->id)
                                                    <li class="cart_item">
                                                        <span class="name">{{$d->nama}}</span>
                                                        <span class="index">({{ $d->qty }})</span>
                                                        <span class="price">Rp.{{ number_format($d->harga) }}</span>
                                                    </li>
                                                    @endif
                                                    @endforeach
                                                </ul>
                                                <div class="total">
                                                    <span class="size-12 nunito">Sub Total ({{$countbuy}} Barang)</span>
                                                    <span class="total_price">Rp. {{ number_format($trans->sub_total) }}</span>
                                                    <br>
                                                    <span class="size-12 nunito">Ongkos Kirim ({{number_format(($trans->total_berat/1000),2)}} Kg)</span>
                                                    <span class="total_price">Rp. {{ number_format($trans->total_ongkir) }}</span>
                                                    <br>
                                                    <span class="size-12 nunito">Diskon</span>
                                                    <span class="total_price">Rp. 0</span>
                                                    <br>
                                                    <span class="size-12 nunito">Kode unik</span>
                                                    <span class="total_price">Rp. {{ number_format($trans->unix_code) }}</span>
                                                    <br>
                                                    <span class="size-16">Total</span>
                                                    <span class="total_prices size-16">Rp. {{ number_format($trans->total_bayar) }}</span>
                                                </div>
                                            
                                            </div>
                                        </div>
                                    </div>
                                    @if ($status_invoice->status == 0)
                                    <div class="box mb-3">
                                        <p class="nunito">BELUM DIBAYAR</p>
                                    </div>
                                    @else
                                    <div class="box2 mb-3">
                                        <p class="nunito">SUDAH DIBAYAR</p>
                                    </div>
                                    @endif
                                    <div class="foot">
                                        <?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($no_transaksi, 'C39+',3,120) . '" alt="barcode"   />'; ?>
                                    </div>
                                </div>

                            </div>
                        </div>
            </div>
           
        </div>
    </div>

@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    
    function myFunction() {
      // Get the text field
      var copyText = document.getElementById("myInput");
    
      // Select the text field
      copyText.select();
      copyText.setSelectionRange(0, 99999); // For mobile devices
    
      // Copy the text inside the text field
      navigator.clipboard.writeText(copyText.value);
      
      // Alert the copied text
      const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-start',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
        })

        Toast.fire({
        icon: 'success',
        title: 'Nomer ATM Berhasil di salin',
        })
    //   Swal.fire({
    //     title: 'Berhasil!',
    //     text: 'No ATM Berhasil di salin',
    //     icon: 'success',
    //     confirmButtonText: 'Ok'
    //     })
    }
    </script>
@stop