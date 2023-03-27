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
            <div class="container-fluid">
                <div class="row" >
                    <div class="col-sm-12">
                        <div id="inam" class="carousel slide" data-interval="false">
                            <div class="carousel-inner">
                                <?php $i = 0; ?>
                                @foreach ($category as $item)
                                    <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                                       <div class="container-fluid">
                                        <div class="row justify-content-center" style="display: flex;flex-wrap:nowrap;margin:0">
                                            @foreach  (array_slice($category, 0, 6) as $items)
                                                
                                       
                                             {{-- <div class="col-sm-6 col-6 col-lg-2" style="width: auto !important;   display: table;"> --}}
                                                 <div class="card card-slider">
                                            
                                                     <p class="nunito" style="line-height: 2.5"><i class="fa fa-home ml-1 mr-1"></i> {{ $items['name'] }}</p>
                                         
                                                 </div>
                                                 
                                             {{-- </div> --}}
                                             @endforeach
                                         </div>
                                       </div>
                                        <?php $i++ ?>
                                    </div>
        
                                    <div class="carousel-item">
                                        <div class="container-fluid">
                                            <div class="row justify-content-start" style="display: flex;flex-wrap:nowrap;margin:0">
                                            @foreach  (array_slice($category, 6, 14) as $items)

                                                <div class="card card-slider">
                                            
                                                    <p class="nunito" style="line-height: 2.5"><i class="fa fa-home ml-1 mr-1"></i> {{ $items['name'] }}</p>
                                        
                                                </div>
                                                 
                                                @endforeach
                                            </div>
                                             
                                             
                                         </div>
                                    </div>
                                @endforeach
                            </div>
                            <a href="#inam" class="carousel-control-prev" data-slide="prev" style="background:#eaeaea;color:#fff;margin-top:15px">
                                <span class="carousel-control-prev-icon" ></span>
                            </a>
                            <a href="#inam" class="carousel-control-next" data-slide="next" style="background:#eaeaea;color:#fff;margin-top:15px">
                                <span class="carousel-control-next-icon" ></span>
                            </a>
                            
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
            @if (session('message'))
                <div class="m-3 p-3 w-100 alert alert-{{ session('alert') }} text-center">{{ session('message') }}</div>
            @endif
            <div id="custom_carousel" class="col-lg-12">
                <div class="container-fluid">
                    <hr>
                    <h2 class="nunito bolder mb-3">Produk Pilihan </h1>
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
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                <div class="container-fluid">
                    <hr>
                    <h2 class="nunito bolder mb-3">Produk</h1>
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
    </div>

@endsection
{{-- @section('script')
{{-- <script>
    $('#recipeCarousel').carousel({
  interval: 10000
})

$('.carousel .carousel-item').each(function(){
    var minPerSlide = 3;
    var next = $(this).next();
    if (!next.length) {
    next = $(this).siblings(':first');
    }
    next.children(':first-child').clone().appendTo($(this));
    
    for (var i=0;i<minPerSlide;i++) {
        next=next.next();
        if (!next.length) {
        	next = $(this).siblings(':first');
      	}
        
        next.children(':first-child').clone().appendTo($(this));
      }
});

</script>
@stop --}} 