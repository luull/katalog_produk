@extends('branch.templates.master')
@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span>Detil Transaction</span></li>
                </ol>
            </nav>
        </div>
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

            <div class="row justify-content-center">
                <div clas="col-12">
                    <h4 class="nunito bolder mb-4 text-center">No Transaksi {{ $no_transaksi }}</h4>

                </div>
            </div>
            <div class="row ">


                <div class="col-md-6">

                    <h6 class="nunito bolder mb-4">Daftar Barang</h6>
                    @php
                        $countbuy = 0;
                    @endphp
                    @foreach ($data as $d)
                        @php
                            $countbuy++;
                        @endphp
                        <div class="card card-cart mb-3 ">

                            <div class="card-body">
                                <div class="row pl-3">
                                    <div class="col-md-2 col-sm-3 col-xs-3 col-3 align-self-start">
                                        <img alt="avatar" src="{{ asset($d->image) }}" class="img-fluid">
                                    </div>
                                    <div class="col-md-10 col-sm-9 col-xs-9 col-9 align-self-center">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="hidden" id="berat" value="{{ $d->berat }}">
                                                <h6 class="size-16">{{ $d->nama }}</h6>
                                                <p class="semi-bolder size-14 mb-0">Rp.{{ number_format($d->harga) }} |
                                                    Jumlah ({{ $d->qty }})</p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 col-12 align-self-center">
                                        <hr>

                                    </div>
                                </div>
                            </div>
                        </div>


                    @endforeach
                </div>
                <div class="col-md-6">
                    <div class="card card-cart2">
                        <div class="card-body">
                            <h6 class="nunito bolder">Ringkasan Belanja</h6>
                            <p class="size-16">Total Harga ({{ $countbuy }} Barang)
                                <span style="float: right;">Rp. {{ number_format($trans->total) }}</span>
                            </p>
                            <p class="size-16">Ongkos Kirim ({{ $trans->total_berat }} Gram)
                                <span style="float: right;">Rp. {{ number_format($trans->total_ongkir) }}</span>
                            </p>
                            <p class="size-16">Total Diskon Barang
                                <span style="float: right;">Rp. 0</span>
                            </p>
                            <hr>
                            <h6 class="nunito bolder">Total Belanja <span style="float: right;">Rp.
                                    {{ number_format($trans->total) }}</span></h6>
                            <hr>
                            <h6 class="nunito bolder">Kode Unik <span style="float: right;">Rp.
                                    {{ number_format($trans->unix_code) }}</span></h6>
                            <hr>
                            <h6 class="nunito bolder">Total Yang harus di transfer <span class="text-danger"
                                    style="float: right;">Rp. {{ number_format($trans->total_bayar) }}</span></h6>

                        </div>
                    </div>
                </div>

            </div>
            @php
                $status_invoice = \App\Transaction::where('id_transaction', $no_transaksi)->first('status');
            @endphp
            @if ($status_invoice->status == 0)
                <div class="row mt-3 justify-content-center">
                    <div class="col-md-6">
                        <div class="card card-cart2">
                            <div class="card-body">

                                <p class="nunito bolder">Silahkan lakukan pembayaran ke No Rek berikut :
                                <table border=0 cellpadding=5 cellspacing=1>
                                    @foreach ($bank as $b)
                                        <tr>
                                            <td>Nama Bank</td>
                                            <td> : </td>
                                            <td> {{ $b->nama_bank }}</td>
                                        </tr>
                                        <tr>
                                            <td>No Rekening</td>
                                            <td> : </td>
                                            <td> {{ $b->no_akun }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pemilik Rekening</td>
                                            <td> : </td>
                                            <td> {{ $b->nama_akun }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td>Nominal Yang ditransfer</td>
                                        <td> : </td>
                                        <td class="text-danger"> {{ $trans->total_bayar }}</td>
                                    </tr>
                                </table>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
