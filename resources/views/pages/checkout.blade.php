@extends('templates.master')
@section('content')
<style>
    input[type="radio"]:checked{
    visibility:hidden;
}
input[type="radio"]{
    visibility:hidden;
}

</style>
    <div class="container-fluid mt-5">
        @if (session('message'))
            <div class="row ">
                <div class="m-3 p-3 w-100 alert alert-{{ session('alert') }} text-center">{{ session('message') }}
                </div>
            </div>
        @endif
        <div class="row ">
            <div class="col-md-12">
                <div class="breadcrumb-five">
                    <ul class="breadcrumb">
                        <li class="active mb-2"><a href="/">Beranda</a>
                        </li>
                        <li class="mb-2"><a href="javscript:void(0);">Proses Checkout</a></li>

                    </ul>
                </div>
            </div>

            <div class="col-lg-8 mt-4">
                <h3 class="nunito bolder mb-3">Checkout</h3>
                <p class="nunito bolder black size-16">Alamat Pengiriman</p>
                <hr>
                <p class="size-12"><b>{{ $getaddress->name }}</b> ({{ $getaddress->category }})</p>
                <p class="size-12 mb-0">{{ $getaddress->phone }}</p>
                <p class="text-muted size-12">{{ $getaddress->address }}, {{ $getaddress->city_name }},
                    {{ $getaddress->subdistrict_name }}, {{ $getaddress->province }}, {{ $getaddress->kd_pos }}</p>
                <hr>
                <button class="btn btn-default" data-toggle="modal" data-target="#editAddress">Ubah alamat</button>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group ">
                            <input type="hidden" value="6" class="form-control" name="province_origin">
                        </div>
                        <div class="form-group ">
                            <input type="hidden" value="153" class="form-control" id="city_origin" name="city_origin">
                        </div>
                        <div class="form-group ">
                            <input type="hidden" value="city" class="form-control" id="destinationType"
                                name="destinationType">
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" value="{{ $getaddress->city }}" name="get_kota"
                                placeholder="ini untuk menangkap nama kota">
                        </div>
                        <div class="form-group ">
                            <label>Pilih Ekspedisi<span>*</span>
                            </label>
                            <div class="paymentCont">
                             
                                <div class="paymentWrap">
                                    <div class="btn-group paymentBtnGroup btn-group-justified" data-toggle="buttons">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="btn paymentMethod">
                                                    <div class="method jne"></div>
                                                    <input type="radio" value="jne" name="kurir" id="kurir"> 
                                                </label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="btn paymentMethod">
                                                    <div class="method sicepat"></div>
                                                    <input type="radio" value="sicepat" name="kurir" id="kurir"> 
                                                </label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="btn paymentMethod">
                                                    <div class="method anteraja"></div>
                                                    <input type="radio" value="anteraja" name="kurir" id="kurir"> 
                                                </label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="btn paymentMethod">
                                                    <div class="method ninja"></div>
                                                    <input type="radio" value="ninja" name="kurir" id="kurir"> 
                                                </label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="btn paymentMethod">
                                                    <div class="method tiki"></div>
                                                    <input type="radio" value="tiki" name="kurir" id="kurir"> 
                                                </label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="btn paymentMethod">
                                                    <div class="method pos"></div>
                                                    <input type="radio" value="pos" name="kurir" id="kurir"> 
                                                </label>
                                            </div>
                                          
                                        </div>
                                     
                                    </div>        
                                </div>
                               
                            </div>
                          
                        </div>
                        <div class="form-group">
                            <label>Pilih Layanan<span>*</span>
                            </label>
                            <select name="layanan" id="layanan" class="form-control">
                                <option value="">Pilih layanan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="ongkoskirim" name="ongkoskirim"
                                placeholder="ini untuk menangkap nama kota">
                        </div>

                    </div>
                    <div class="col-md-4">

                        <div class="form-group ">
                            {{-- <label>total berat (gram) </label> --}}
                            <input class="form-control" type="hidden" value="{{ $berat }}" id="weight"
                                name="weight">
                        </div>
                        <div class="form-group ">
                            {{-- <label>Total Belanja<span>*</span> --}}
                            </label>
                            <input type="hidden" value="{{ $sum }}" name="totalbelanja" class="form-control">
                        </div>
                        <div class="form-group">
                            {{-- <label>Total</label> --}}
                            <input type="hidden" class="form-control" id="ongkoskirim" name="ongkoskirim"
                                placeholder="ini untuk menangkap nama kota">
                        </div>
                        <div class="form-group ">
                            {{-- <label>total keseluruhan </label> --}}
                            <input class="form-control" type="hidden" id="total" name="total">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <form id="myForm" action="{{ route('add-transaction') }}" method="post">
                    @csrf
                    <input type="hidden" name="id_transaction" value="{{ $getid }}">
                    <input type="hidden" name="id_address" value="{{ $getaddress->ctid }}">
                    <input type="hidden" name="ongkir" id="get_ongkir">
                    <input type="hidden" name="etd" id="etd">
                    <input type="hidden" name="berat" value="{{ $berat }}">
                    <input type="hidden" name="total" id="get_total">
                    <input type="hidden" name="kurir" id="courier">
                    <div class="card card-cart2">
                        <div class="card-body">
                            <h4 class="nunito bolder">Ringkasan Belanja</h4>
                            <p class="size-16">Total Harga ({{ $countbuy }} Barang)
                                <span style="float: right;">Rp. {{ number_format($sum) }}</span>
                            </p>
                            <p class="size-16">Total Ongkir ({{ number_format($berat / 1000, 2) }}) Kg
                                <span id="ongkirnya" style="float: right;"></span>
                            </p>
                            <p class="size-16">Total Diskon Barang
                                <span style="float: right;">Rp. 0</span>
                            </p>
                            <hr>
                            <h4 class="nunito bolder">Total Harga <span id="totalnya"
                                    style="float: right;color:#f9591d;"></span></h4>
                            <div id="bank">
                                <hr>
                                <p class="size-16">Pembayaran ke rek

                                </p>
                                <select name="bank" class="form-control none">
                                    @foreach ($bank as $b)
                                        <option value="{{ $b->no_akun }}#{{ $b->nama_bank }}">{{ $b->nama_bank }} -
                                            {{ $b->no_akun }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit"
                                class="btn btn-block mt-5 bolder nunito size-18 p-2 {{ $sum == '0' ? 'btn-default disabled' : 'btn-success' }}">Proses
                                Pembayaran</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
    <!-- Modal edit-->
    <div class="modal fade" id="editAddress" tabindex="-1" role="dialog" aria-labelledby="editAddressLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAddressLabel">Ubah Alamat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('change-pick') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group ">
                            <label>Pilih Alamat<span>*</span>
                            </label>
                            <select name="nama_kota" id="nama_kota" value="{{ old('nama_kota') }}" class="selectpicker"
                                required>
                                @foreach ($getcontact as $g)
                                    @if ($g->status == 1)
                                        <optgroup label="{{ $g->name }} ({{ $g->category }}) UTAMA">
                                        @else
                                        <optgroup label="{{ $g->name }} ({{ $g->category }})">
                                    @endif
                                    <option namakota="{{ $g->city }}" value="{{ $g->ctid }}"
                                        data-subtext="{{ $g->city_name }}, {{ $g->subdistrict_name }}, {{ $g->province }}, {{ $g->kd_pos }}">
                                        {{ $g->address }}</option>
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@stop
@section('script')
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
    @if (session('alert') === 'success')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}">
        </script>
        <script>
            /*$(document).ready(function(){
            //midtrans({{ $getToken }});
        });*/
            function midtrans(getToken) {
                snap.pay(getToken, {
                    // Optional
                    onSuccess: function(result) {
                        /* You may add your own js here, this is just example */
                        document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    },
                    // Optional
                    onPending: function(result) {
                        /* You may add your own js here, this is just example */
                        document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        window.location = "/myorder"
                    },
                    // Optional
                    onError: function(result) {
                        /* You may add your own js here, this is just example */
                        document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    }
                });
            }

        </script>
    @endif
    <script>
        $(document).ready(function() {
            $("#bank").hide();
            $("input[type='radio']").click(function(){
                var courier = $("input[name='kurir']:checked").val();
                let origin = $("input[name=city_origin]").val();
                let destination = $("input[name=get_kota]").val();
                let weight = $("input[name=weight]").val();
                var destinationType = $("#destinationType").val();
                console.log('bla',courier);
                $("#courier").val(courier);
                if (courier) {
                    $.ajax({
                        url: "/origin=" + origin + "&destination=" + destination +
                            "&destinationType=" + destinationType + "&weight=" + weight +
                            "&courier=" + courier,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if(data){
                                
                                $('select[name="layanan"]').empty();
                                $('select[name="layanan"]').append(
                                    '<option selected>Pilih Layanan</option>');
                                $.each(data, function(key, value) {
                                    $.each(value.costs, function(key1, value1) {
                                        $.each(value1.cost, function(key2, value2) {
                                            var number_string = value2.value
                                                .toString(),
                                                sisa = number_string
                                                .length % 3,
                                                hasil = number_string
                                                .substr(0, sisa),
                                                ribuan = number_string
                                                .substr(sisa).match(
                                                    /\d{3}/g);
    
                                            if (ribuan) {
                                                separator = sisa ? '.' : '';
                                                hasil += separator + ribuan
                                                    .join('.');
                                            }
                                            $('select[name="layanan"]')
                                                .append('<option value="' +
                                                    key +
                                                    '" harga_ongkir="' +
                                                    value2.value +
                                                    '" etd="' + value2.etd +
                                                    '">' + value1.service +
                                                    '-' + hasil +
                                                    ' Estimasi ' + value2
                                                    .etd + ' Hari</option>'
                                                );
                                        });
                                    });
                                });
                            }else{
                                $('#layanan').remove() 
                            }
                        }
                    });
                } else {
                    $('select[name="layanan"]').empty();
                }
            });
            $('select[name="layanan"]').on('change', function() {
                $("#bank").hide();
                var harga_ongkir = $("#layanan option:selected").attr("harga_ongkir");
                var etd = $("#layanan option:selected").attr("etd");
                $("#ongkoskirim").val(harga_ongkir);
                $("#etd").val(etd);
                let totalbelanja = $("input[name=totalbelanja]").val();
                // menampilkan hasil nama harga ongkir dari select layanan yg kita pilih
                // kita akan menampilkan harga ongkirnya di id ongkos kirim, jadi kalian bisa buat inputan dengan id ongkos kirim
                let total = parseInt(totalbelanja) + parseInt(harga_ongkir);
                $("#get_ongkir").val(harga_ongkir);
                $("#get_total").val(total);
                // ini untuk jumlah total nya y,, jd jumlah belanja di tambah jumlah ongkos kirim
                $("#total").val(total);
                var number_string = harga_ongkir.toString(),
                    sisa = number_string.length % 3,
                    rupiah = number_string.substr(0, sisa),
                    ribuan = number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
                var number_string2 = total.toString(),
                    sisa2 = number_string2.length % 3,
                    rupiah2 = number_string2.substr(0, sisa2),
                    ribuan2 = number_string2.substr(sisa2).match(/\d{3}/g);

                if (ribuan2) {
                    separator2 = sisa2 ? '.' : '';
                    rupiah2 += separator2 + ribuan2.join('.');
                }
                document.getElementById("ongkirnya").innerHTML = 'Rp.' + rupiah;
                document.getElementById("totalnya").innerHTML = 'Rp.' + rupiah2;
                if (harga_ongkir > 0 && totalbelanja > 0) {
                    $("#bank").show();
                }
                //kita menampilkan totalnya di id total
            });
        });

    </script>


@stop
