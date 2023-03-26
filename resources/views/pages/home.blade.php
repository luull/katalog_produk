@extends('templates.master')
@section('content')

    <div class="container-fluid mt-5">

        <div class="row">
            <div class="col-lg-12">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <!-- <ol class="carousel-indicators">
                                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active m"></li>
                                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                        </ol>
                                        <div class="carousel-inner">
                                            
                                            <div class="carousel-item active">
                                                <img class="d-block w-100" src="{{ asset('templates/assets/img/slide/4.png') }}" alt="First slide">
                                            </div>
                                            <div class="carousel-item">
                                                <img class="d-block w-100" src="{{ asset('templates/assets/img/slide/3.png') }}" alt="Second slide">
                                            </div>
                                            <div class="carousel-item">
                                                <img class="d-block w-100" src="{{ asset('templates/assets/img/slide/4.png') }}" alt="Third slide">
                                            </div>
                                        </div>-->

                    <ol class="carousel-indicators">
                        @for ($x = 0; $x < count($banner); $x++)
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $x }}"
                                class="{{ $x == 0 ? 'active m' : '' }}"></li>

                        @endfor
                    </ol>
                    <div class="carousel-inner">
                        <?php $x = 0; ?>
                        @foreach ($banner as $b)

                            <div class="carousel-item {{ $x == 0 ? 'active' : '' }}">
                                <img class="d-block w-100" src="{{ asset($b->image) }}">
                            </div>
                            <?php $x++; ?>
                        @endforeach


                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            @if (session('message'))
                <div class="m-3 p-3 w-100 alert alert-{{ session('alert') }} text-center">{{ session('message') }}</div>
            @endif
            <div id="custom_carousel" class="col-lg-12">
                <div class="container-fluid">
                    <hr>
                    <h2 class="nunito bolder mb-3">Produk Pilihan </h1>
                        <div class="row mb-3">
                            @foreach ($produk_display as $item)
                                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-6 col-6 mb-3">
                                    <a href="/detil-produk/{{ $item->slug }}">
                                        <div class="card" style="width:100% !important;">
                                            <img src="{{ asset($item->image) }}" class="card-img-top"
                                                alt="widget-card-2">
                                            <div class="card-body product">
                                                <h5 class="card-title mb-1">{{ $item->nama }}</h5>
                                                <h5 class="mb-2"><b>Rp.<?php echo
                                                        number_format($item->harga); ?></b></h5>
                                                {{-- <p class="card-text">{!! Str::limit($item->keterangan_singkat, 50, '...') !!}</p> --}}

                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                <div class="container-fluid">
                    <hr>
                    <h2 class="nunito bolder mb-3">Produk</h1>
                    <div class="row mb-3">
                        @foreach ($product as $item)
                            <?php
                            $firsturl = str_replace(' ', '%20', $item->name);
                            $resulturl = str_replace('&', 'n', $firsturl);
                            ?>
                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-6 col-6 mb-3">
                                <a href="/detil-produk/{{ $item->slug }}">
                                    <div class="card" style="width:100% !important;">
                                        <img src="{{ asset($item->image) }}" class="card-img-top" alt="widget-card-2">
                                        <div class="card-body product">
                                            <h5 class="card-title mb-1">{{ $item->nama }}</h5>
                                            <h5 class="mb-2"><b>Rp.<?php echo number_format($item->harga);
                                                    ?></b></h5>
                                            {{-- <p class="card-text">{!! Str::limit($item->keterangan_singkat, 50, '...') !!}</p> --}}

                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
