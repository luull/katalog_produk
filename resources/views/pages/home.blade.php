@extends('templates.master')
@section('content')

    <div class="container-fluid mt-5">

        <div class="row">
            <div class="col-lg-12">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
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
            </div>
            <div class="row row-no-padding">
                <div class="col-md-12 mt-3">
                    <div class="card" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;;border:0">
                        <div class="card-body">
                           <div class="row ">
                            <div class="col-md-12">
                                <h2 class="nunito bolder mb-3 size-24 title">Kategori Pilihan </h1>
                                <div class="row row-no-padding">
                                    @foreach ($category as $item )
                                    
                                    <div class="col-md-2 col-6 mb-2">
                                            @if (!empty($item['product']))
                                            <a href="/categoryproduct/{{ $item['id'] }}/-/-/{{ $item['name'] }}">
                                            @else
                                            <a onclick="noproduct()">
                                            @endif
                                            <div class="card card-category">
                                          
                                                    <i class="fa fa-{{ $item['icon'] }} mb-2"></i>
                                                    <h2 class="size-14 semi-bolder nunito">{{ $item['name'] }}</h2>
                                            
                                            </div>
                                            </a>
                                        </div>
                              
                                    @endforeach
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <h2 class="nunito bolder mb-3 size-18 title">Kategori Pilihan </h1>
                                <div class="row justify-content-end row-no-padding">
                                    @foreach ($category as $item )
                                    @if (empty($item['product']))
                                        
                                        <div class="col-md-3 col-6 mb-2">
                                            <div class="card card-category">
                                          
                                                    <i class="fa fa-home mb-2"></i>
                                                    <h2 class="size-14 semi-bolder nunito">{{ $item['name'] }}</h2>
                                            
                                            </div>
                                            
                                        </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                             --}}
              
                           </div>
                        </div>
                    </div>
                </div>
            </div>
 
            @if (session('message'))
                <div class="m-3 p-3 w-100 alert alert-{{ session('alert') }} text-center">{{ session('message') }}</div>
            @endif
            <div class="row">
            <div id="custom_carousel" class="col-lg-12">
           
                    <hr>
                    <h2 class="nunito bolder mb-3 title">Produk Pilihan </h1>
                        <div class="row row-no-padding mb-3">
                            @foreach ($produk_display as $item)
                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-6 col-6 mb-3">
                                <a href="/detil-produk/{{ $item->slug }}">
                                    <div class="card card-product">
                                        <img src="{{ asset($item->image) }}" class="card-img-top" alt="widget-card-2">
                                        <div class="card-body product">
                                            <div class="height-title">
                                                @if(\Str::length($item->nama) > 35)
                                                    <h5 class="card-title-produk-resize mb-1">{{ $item->nama }}</h5>
                                                @else
                                                    <h5 class="card-title-produk mb-1">{{ $item->nama }}</h5>
                                                @endif
                                                
                                            </div>
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

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                    <hr>
                    <h2 class="nunito bolder mb-3 title">Produk</h1>
                    <div class="row row-no-padding mb-3">
                        @foreach ($product as $item)
                            <?php
                            $firsturl = str_replace(' ', '%20', $item->name);
                            $resulturl = str_replace('&', 'n', $firsturl);
                            ?>
                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-6 col-6 mb-3">
                                <a href="/detil-produk/{{ $item->slug }}">
                                    <div class="card card-product">
                                        <img src="{{ asset($item->image) }}" class="card-img-top" alt="widget-card-2">
                                        <div class="card-body product">
                                            <div class="height-title">
                                                @if(\Str::length($item->nama) > 35)
                                                    <h5 class="card-title-produk-resize mb-1">{{ $item->nama }}</h5>
                                                @else
                                                    <h5 class="card-title-produk mb-1">{{ $item->nama }}</h5>
                                                @endif
                                                
                                            </div>
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

@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function noproduct(){
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
        icon: 'warning',
        title: 'Produk belum tersedia',
        })
    }
</script>
@stop