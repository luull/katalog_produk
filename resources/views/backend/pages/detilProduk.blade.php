@extends('backend.templates.master')
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
                    <li class="breadcrumb-item active" aria-current="page"><a href="/backend/produk"><span>Produk</span></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><span>Detil Produk</span>
                    </li>

                </ol>
            </nav>
        </div>
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="row">

                <div class="col-12 text-center ">
                    <h4 class="nunito bolder mb-2">{{ $product->nama }} </h4>
                </div>
                <div class="col-md-4 text-center">
                    <hr>

                    <div class="text-center">
                        <img src="{{ asset($product->image) }}" class="img-fluid" style="width:300px;" alt="">
                    </div>
                    <h4 class="nunito bolder mb-4 mt-2">Rp.<?php echo number_format($product->harga); ?></h4>
                </div>
                <div class="col-md-8 mb-3">
                    <hr>



                    <ul class="nav nav-tabs  mb-3 nav-fill" id="justifyTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link nunito bolder active" id="justify-home-tab" data-toggle="tab"
                                href="#justify-home" role="tab" aria-controls="justify-home" aria-selected="true">Info
                                Produk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nunito bolder" id="justify-profile-tab" data-toggle="tab"
                                href="#justify-profile" role="tab" aria-controls="justify-profile"
                                aria-selected="false">Detail</a>
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
                        <div class="tab-pane fade" id="justify-profile" role="tabpanel"
                            aria-labelledby="justify-profile-tab">

                            <p class="mb-4">
                                {!! $product->keterangan !!}
                            </p>

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
    <a href="javascript:history.back(-1)" class="btn btn-info btn-sm ml-3">Kembali</a>

    </div>
@endsection
