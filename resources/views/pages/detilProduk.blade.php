@extends('templates.master')
@section('content')

    <div class="container-fluid mt-5">


        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-five">
                    <ul class="breadcrumb">
                        <li class="active mb-2"><a href="/">Beranda</a>
                        </li>
                        <li class="mb-2"><a href="/display-product">Produk</a></li>
                        <li class="mb-2"><a href="javscript:void(0);">{{ $product->nama }}</a></li>

                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <hr>
                <div class="text-center">
                    <img src="{{ asset($product->image) }}" class="img-fluid" style="width:300px;" alt="">
                </div>
            </div>
            <div class="col-md-5 mb-3">
                <hr>
                <h4 class="nunito bolder mb-2">{{ $product->nama }} </h4>
                <p>&nbsp;</p>
                <div class="breadcrumb-five">
                    <?php
                    /* <ul class="breadcrumb">
                        <li class="mb-4"><a href="javscript:void(0);">Terjual 60</a></li>
                        <li class="mb-4"><a href="javscript:void(0);"> (40) Ulasan </a></li>

                    </ul>*/
                    ?>
                </div>
                <h3 class="nunito bolder mb-4">Rp.<?php echo number_format($product->harga); ?></h3>
                <ul class="nav nav-tabs  mb-3 mt-3 nav-fill" id="justifyTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link nunito bolder active" id="justify-home-tab" data-toggle="tab"
                            href="#justify-home" role="tab" aria-controls="justify-home" aria-selected="true">Info
                            Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nunito bolder" id="justify-profile-tab" data-toggle="tab" href="#justify-profile"
                            role="tab" aria-controls="justify-profile" aria-selected="false">Detail</a>
                    </li>
                </ul>

                <div class="tab-content" id="justifyTabContent">
                    <div class="tab-pane fade show active" id="justify-home" role="tabpanel"
                        aria-labelledby="justify-home-tab">
                        <p><strong>Berat : {{ $product->berat }} gram</strong></p>
                        <p class="mb-4">
                            {!! $product->keterangan_singkat !!}
                        </p>


                    </div>
                    <div class="tab-pane fade" id="justify-profile" role="tabpanel" aria-labelledby="justify-profile-tab">

                        <p class="mb-4">
                            {!! $product->keterangan !!}
                        </p>

                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <hr>
                <div class="card">
                    <div class="card-body">
                        <h4 class="nunito bolder mb-3">Atur Jumlah dan catatan</h4>
                        <form action="{{ route('add-cart') }}" method="POST">
                            <div class="mb-3">
                                @csrf
                                <input type="hidden" name="id_barang" value="{{ $product->id }}">
                                <input type="text" id="demo6" value="1"
                                    style="width: 20% !important;text-align:center !important;" name="qty">
                            </div>

                            <hr>
                            <div class="row mt-4">
                                {{-- <form id="myForm" action="{{ route('add-dummy')}}" method="post">
                                            @csrf
                                            <input type="hidden" value="{{$product->name}}" name="id_barang">
                                            <input type="hidden" value="{{$product->berat}}" name="berat">
                                            <div class="col-md-5 mb-2">
                                                <button class="btn btn-outline-success btn-block">Beli</button>
                                            </div>
                                        </form> --}}
                                @if (session('isCustomerLogin'))
                                    <div class="col-md-12 mb-2">
                                        <button type="submit" class="btn btn-sm btn-success btn-block"> <i
                                                data-feather="plus"></i> Keranjang</button>
                                    </div>
                                @else
                                    <div class="col-md-12 mb-2">
                                        <a href="/login" class="btn btn-sm btn-success btn-block"> <i
                                                data-feather="plus"></i> Keranjang</a>
                                    </div>
                                @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

@endsection
@section('script')

@endsection
