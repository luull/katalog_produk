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
                                <li class="mb-2"><a href="javscript:void(0);">{{$getcategory->name}}</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 col-12">
                        <div class="container-fluid">
                            <hr>
                            <div class="row">
                                <h4 class="nunito bolder mb-3">Filter</h4>
                                <div id="withoutSpacing" class="no-outer-spacing" style="width: 100% !important;">
                                    <div class="card">
                                        <div class="card-header mb-0" id="headingOne2">
                                            <section class="mb-0 mt-0">
                                                <div role="menu" class="" data-toggle="collapse" data-target="#withoutSpacingAccordionOne" aria-expanded="true" aria-controls="withoutSpacingAccordionOne">
                                                    <span class="nunito bolder black mb-0">Kategori</span>  <i style="float: right !important;" class="black" data-feather="chevron-down"></i>
                                                </div>
                                            </section>
                                        </div>

                                        <div id="withoutSpacingAccordionOne" class="collapse show" aria-labelledby="headingOne2" data-parent="#withoutSpacing">


                                             <div class="card-body">
                                                <div id="iconsAccordion" class="accordion-icons">
                                                    @foreach ($category as $c )


                                                    <div class="card">
                                                        <div class="card-header" id="...">
                                                            <section class="mb-0 mt-0">
                                                                <div role="menu" class="collapsed" data-toggle="collapse" data-target="#iconAccordion{{$c->id}}" aria-expanded="true" aria-controls="iconAccordion{{$c->id}}">
                                                                    <div class="accordion-icon"><i data-feather="home"></i></div>
                                                                   <span class="{{$id == $c->cid ? 'active-cat' : ''}}"> {{$c->name}} </span>  <div class="icons"><svg> ... </svg></div>
                                                                </div>
                                                            </section>
                                                        </div>

                                                        <div id="iconAccordion{{$c->id}}" class="collapse {{$id == $c->cid ? 'show' : ''}}" aria-labelledby="..." data-parent="#iconsAccordion">
                                                            <div class="card-body">

                                                                <p class="mb-0 ml-4">
                                                                    <i class="fa fa-angle-right mr-3"></i><a class="{{$id == $c->cid ? 'active-cat' : ''}}" href="/filterproduct/{{$c->cid}}">{{$c->sub_category}}</a>
                                                                </p>


                                                            </div>
                                                        </div>
                                                    </div>
                                                  @endforeach
                                                </div>
                                             </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header" id="headingThree4">
                                            <section class="mb-0 mt-0">
                                                <div role="menu" class="collapsed" data-toggle="collapse" data-target="#withoutSpacingAccordionThree" aria-expanded="false" aria-controls="withoutSpacingAccordionThree">
                                                    <span class="nunito bolder black mb-0">Harga</span>  <i style="float: right !important;" class="black" data-feather="chevron-down"></i>
                                                </div>
                                            </section>
                                        </div>
                                        <div id="withoutSpacingAccordionThree" class="collapse" aria-labelledby="headingThree4" data-parent="#withoutSpacing">
                                            <div class="card-body">

                                                ................
                                                ................

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12 col-12">
                        <div class="container-fluid">
                            <hr>
                            <p class="mb-4">Menampilkan {{ count($product) }} produk untuk "<strong>{{ $getcategory->name }}</strong>"</p>
                            @if(count($product) >= 1)
                                <div class="row mb-3">
                                    @foreach ($product as $item)
                                    @if ($item->kategori == $id)
                                    <?PHP
                                    $firsturl = str_replace(" ", "%20", $item->name);
                                    $resulturl = str_replace("&", "n", $firsturl);
                                    ?>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6 mb-3">
                                        <a href="/defaultProduk/{{$item->id}}">
                                        <div class="card" style="width:100% !important;">
                                            <img src="{{ asset($item->image) }}" class="card-img-top" alt="widget-card-2">
                                            <div class="card-body product">
                                                <h5 class="card-title mb-1">{{ $item->name }}</h5>
                                                <h5 class="mb-2"><b>Rp.<?PHP echo number_format($item->harga); ?></b></h5>
                                                {{-- <p class="card-text">{!! Str::limit($item->keterangan_singkat, 50, '...') !!}</p> --}}

                                            </div>
                                        </div>
                                        </a>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center mt-5">
                                    <h3 class="nunito bolder">Oppss..Produk {{ $getcategory->name }} tidak ada</h3>
                                    <p>Silahkan gunakan kata kunci yang mudah untuk pencarian</p>
                                    <img src="{{ asset('templates/assets/img/search.png')}}" class="img-fluid mt-3" style="width: 400px;" alt="">
                                </div>
                            @endif
                        </div>
                    </div>

    </div>
</div>

@endsection
