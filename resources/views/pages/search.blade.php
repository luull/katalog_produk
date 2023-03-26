@extends('templates.master')
@section('content')

<div class="container-fluid mt-5">


            <div class="row">
                    <div class="col-md-12">
                        <div class="breadcrumb-five">
                            <ul class="breadcrumb">
                                <li class="active mb-2"><a href="/">Beranda</a>
                                </li>
                                <li class="mb-2"><a href="javscript:void(0);">Produk</a></li>
                                <li class="mb-2"><a href="javscript:void(0);">{{$search}}</a></li>

                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12 col-12">
                        <div class="container-fluid">
                            <hr>
                            <p class="mb-4">Menampilkan {{ count($product) }} produk untuk pencarian "<strong>{{ $search }}</strong>"</p>
                            @if(count($product) >= 1)
                                <div class="row mb-3">
                                    @foreach ($product as $item)
                                    <?PHP
                                    $firsturl = str_replace(" ", "%20", $item->name);
                                    $resulturl = str_replace("&", "n", $firsturl);
                                    ?>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6 mb-3">
                                         <a href="/detil-produk/{{$item->slug}}">
                                     
                                        <div class="card" style="width:100% !important;">
                                            <img src="{{ asset($item->image) }}" class="card-img-top" alt="widget-card-2">
                                            <div class="card-body product">
                                                <h5 class="card-title mb-1">{{ $item->nama }}</h5>
                                                <h5 class="mb-2"><b>Rp.<?PHP echo number_format($item->harga); ?></b></h5>
                                                {{-- <p class="card-text">{!! Str::limit($item->keterangan_singkat, 50, '...') !!}</p> --}}

                                            </div>
                                        </div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center mt-5">
                                    <h3 class="nunito bolder">Oppss..Produk {{ $search }} tidak ditemukan</h3>
                                    <p>Silahkan gunakan kata kunci yang lainnya</p>
                                    <img src="{{ asset('templates/assets/img/search.png')}}" class="img-fluid mt-3" style="width: 400px;" alt="">
                                </div>
                            @endif
                        </div>
                    </div>

    </div>
</div>

@endsection
