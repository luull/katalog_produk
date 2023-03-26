@extends('templates.master')

@section('content')

    <div class="container-fluid mt-5">


        <div class="row">
            <div id="breadcrumbss"></div>
            <div class="col-md-12">
                <div class="breadcrumb-five">
                    <ul class="breadcrumb">
                        <li class="mb-2"><a href="/">Beranda</a>
                        </li>
                        <li class="mb-2"><a href="javscript:void(0);">Produk</a></li>
                        <li id="bla"><a href="javscript:void(0);" id="name"></a></li>
                        <li id="bla2"><a href="javscript:void(0);" id="name2"></a></li>
                        <li id="bla3"><a href="javscript:void(0);" id="name3"></a></li>

                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 col-12">
                <div class="container-fluid">
                    <hr>
                    <div class="row">
                        <h4 class="nunito bolder mb-3">Filter</h4>

                        <div id="withoutSpacing" class="no-outer-spacing" style="width: 100% !important;">
                            @php
                                $x = 0;
                            @endphp
                            @foreach ($category as $c)
                                @php
                                    $x++;
                                @endphp
                                <div class="card">
                                    <div class="card-header mb-0 pb-0 pt-0 pb-0" id="{{ $c->id }}">
                                        <section class="mb-0 mt-0 pb-0 pt-0">
                                            <div role="menu" data-toggle="collapse" data-target="#ac-{{ $c->id }}"
                                                aria-expanded="true" aria-controls="withoutSpacingAccordionOne">
                                                <span class="nunito bolder black mb-0"><a href="#" id="c"
                                                        onclick="category({{ $c->id }})">{{ ucfirst($c->name) }}</a></span>
                                                <i style="float: right !important;" class="black"
                                                    data-feather="chevron-down"></i>
                                            </div>
                                        </section>
                                    </div>
                                    @php
                                        $xx = 0;
                                    @endphp
                                    <div id="ac-{{ $c->id }}"
                                        class="collapse {{ $x == 1 ? 'show' : '' }} pb-0 pt-0 mb-0 mt-0 "
                                        aria-labelledby="headingOne2" data-parent="#withoutSpacing">

                                        @foreach ($c->sub_category as $sc)
                                            @php
                                                $xx++;
                                            @endphp


                                            <div class="card-body p-0 pl-3 m-0 " >
                                                <div id="iconsAccordion" class="accordion-icons">
                                                    <div class="card m-0 p-0 ">
                                                        <div class="card-header pt-0 mt-0 " id="{{ $sc->id }}">
                                                            <section class="mb-0 mt-0 pt-0 ">
                                                                <div role="menu" class="collapsed" data-toggle="collapse"
                                                                    data-target="#sc-{{ $sc->id }}"
                                                                    aria-expanded="true"
                                                                    aria-controls="iconAccordion{{ $sc->id }}">

                                                                    <span><a href="#" id="sc"
                                                                            onclick="sub_category({{ $sc->id }})">{{ ucfirst($sc->name) }}</a></span>
                                                                    @if (count($sc->sub_sub_category) > 0)
                                                                        <i style="float: right !important;" class="black"
                                                                            data-feather="chevron-down"></i>
                                                                    @endif
                                                                </div>
                                                            </section>
                                                        </div>
                                                        @php
                                                            $xxx = 0;
                                                        @endphp
                                                        <div id="sc-{{ $sc->id }}"
                                                            class="collapse {{ $xxx == 1 ? 'show' : '' }} pb-0 pt-0 pl-3 mb-0 mt-0 "
                                                            aria-labelledby="headingOne2">
                                                            <ul>
                                                                @foreach ($sc->sub_sub_category as $ssc)
                                                                    @php
                                                                        $xxx++;
                                                                    @endphp
                                                                    <li ><a href="#" id="ssc"
                                                                            onclick="sub_sub_category({{ $ssc->id }})">{{ ucfirst($ssc->name) }}</a>
                                                                    </li>



                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        @endforeach
                                    </div>

                                </div>
                            @endforeach


                            <div class="card">
                                <div class="card-header" id="headingThree4">
                                    <section class="mb-0 mt-0">
                                        <div role="menu" class="collapsed" data-toggle="collapse"
                                            data-target="#withoutSpacingAccordionThree" aria-expanded="false"
                                            aria-controls="withoutSpacingAccordionThree">
                                            <span class="nunito bolder black mb-0">Harga</span> <i
                                                style="float: right !important;" class="black"
                                                data-feather="chevron-down"></i>
                                        </div>
                                    </section>
                                </div>
                                <div id="withoutSpacingAccordionThree" class="collapse" aria-labelledby="headingThree4"
                                    data-parent="#withoutSpacing">
                                    <div class="card-body">
                                        <div class="input-group">

                                            <input type="number" name="h1" id="h1" class="form-control p-2" value="10000">

                                            <input type="number" name="h2" id="h2" class="form-control p-2" value="500000">
                                        </div>
                                        <div class="row justify-content-center">
                                            <button class="mt-2 btn btn-info" onclick="harga()">Ok</button>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12 col-12">
                <div class="container-fluid" id="search">
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
                <div class="container-fluid">
                    {{-- <h4 class="mt-3 font-weight-bold text-uppercase text-center" id="judul"></h4> --}}
                    <hr>
                    <p class="mb-4" id="judul"></p>

                    <div id="displayproduct">
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function() {
            // category(1);
            $('#bla').attr('style', 'display:none')  // option 2
            $('#bla2').attr('style', 'display:none')
            $('#bla3').attr('style', 'display:none')
        });

        function harga() {
            var h1 = $("#h1").val();
            var h2 = $("#h2").val();
            $.ajax({
                type: 'get',
                method: 'get',
                url: '/product/range-price/' + h1 + '/' + h2,
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(hsl) {
                    var i;
                    if (hsl.record > 0) {
                        $("#search").remove();
                        html = '<div class="row mb-3">';
                        for (i = 0; i < hsl.record; ++i) {
                            var	number_string = hsl.data[i].harga.toString(),
                                sisa 	= number_string.length % 3,
                                rupiah 	= number_string.substr(0, sisa),
                                ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                                    
                            if (ribuan) {
                                separator = sisa ? '.' : '';
                                rupiah += separator + ribuan.join('.');
                            }
                            html = html +
                                ' <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6 mb-3">';
                            html = html + '<a href="/detil-produk/' + hsl.data[i].slug + '">';
                            html = html + '<div class="card" style="width:100% !important;">';
                            html = html + '<img src="/' + hsl.data[i].image +
                                '" class="card-img-top" alt="widget-card-2">';
                            html = html + '<div class="card-body product">';
                            html = html + '<h5 class="card-title mb-1">' + hsl.data[i].nama + '</h5>';
                            html = html + '<h5 class="mb-2"><b>Rp. ' + rupiah +
                                '</b></h5>';
                            html = html + '</div></div></a></div>';
                        }
                        html = html + '</div>';
                    } else {
                        html =
                            '<div class="alert alert-danger text-center">Daftar Produk dengan Kategori tersebut tidak ditemukan</div>';
                    }
                    $("#judul").html(hsl.title)
                    $("#displayproduct").html(html);

                }
            })
        }

        function category(id) {
            $.ajax({
                type: 'get',
                method: 'get',
                url: '/product/category/' + id,
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(hsl) {
                    var i;
                    if (hsl.record > 0) {
                        $("#search").remove();
                        $('#bla').attr('style', 'display:block')
                        $('#bla2').attr('style', 'display:none')
                        html = '<div class="row mb-3">';
                        for (i = 0; i < hsl.record; ++i) {
                            var	number_string = hsl.data[i].harga.toString(),
                                sisa 	= number_string.length % 3,
                                rupiah 	= number_string.substr(0, sisa),
                                ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                                    
                            if (ribuan) {
                                separator = sisa ? '.' : '';
                                rupiah += separator + ribuan.join('.');
                            }
                            html = html +
                                ' <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6 mb-3">';
                            html = html + '<a href="/detil-produk/' + hsl.data[i].slug + '">';
                            html = html + '<div class="card" style="width:100% !important;">';
                            html = html + '<img src="/' + hsl.data[i].image +
                                '" class="card-img-top" alt="widget-card-2">';
                            html = html + '<div class="card-body product">';
                            html = html + '<h5 class="card-title mb-1">' + hsl.data[i].nama + '</h5>';
                            html = html + '<h5 class="mb-2"><b>Rp. ' + rupiah + '</b></h5>';
                            html = html + '</div></div></a></div>';
                        }
                        html = html + '</div>';
                    } else {
                        html = '<div class="text-center mt-5">'
                            html = '<h3 class="nunito bolder">Oppss..Produk tidak ditemukan</h3>'
                            html = '<p>Silahkan gunakan kategori yang lainnya</p>'
                        html = '</div>'
                    }
                    
                    $("#judul").html(hsl.title)
                    var element = document.getElementById("name");
                    element.classList.add("active");
                    $("#name").html(hsl.name)
                    $("#bla").addClass("active mb-2")
                    $("#bla2").removeClass("active")
                    $("#bla3").removeClass("active")
                    $('#name2').html("") 
                    $('#name3').html("")
                    $("#displayproduct").html(html);

                }
            })
        }

        function sub_category(id) {
            $.ajax({
                type: 'get',
                method: 'get',
                url: '/product/sub-category/' + id,
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(hsl) {
                    var i;
                    if (hsl.record > 0) {
                        $("#search").remove();
                        $('#bla').attr('style', 'display:block')
                        $('#bla2').attr('style', 'display:block')
                        html = '<div class="row mb-3">';
                        for (i = 0; i < hsl.record; ++i) {
                            var	number_string = hsl.data[i].harga.toString(),
                                sisa 	= number_string.length % 3,
                                rupiah 	= number_string.substr(0, sisa),
                                ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                                    
                            if (ribuan) {
                                separator = sisa ? '.' : '';
                                rupiah += separator + ribuan.join('.');
                            }
                            html = html +
                                ' <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6 mb-3">';
                            html = html + '<a href="/detil-produk/' + hsl.data[i].slug + '">';
                            html = html + '<div class="card" style="width:100% !important;">';
                            html = html + '<img src="/' + hsl.data[i].image +
                                '" class="card-img-top" alt="widget-card-2">';
                            html = html + '<div class="card-body product">';
                            html = html + '<h5 class="card-title mb-1">' + hsl.data[i].nama + '</h5>';
                            html = html + '<h5 class="mb-2"><b>Rp. ' + rupiah + '</b></h5>';
                            html = html + '</div></div></a></div>';
                        }
                        html = html + '</div>';
                    } else {
                        html = '<div class="text-center mt-5">'
                            html = '<h3 class="nunito bolder">Oppss..Produk tidak ditemukan</h3>'
                            html = '<p>Silahkan gunakan kategori yang lainnya</p>'
                        html = '</div>'
                    }
                    $("#judul").html(hsl.title)
                    $("#name").html(hsl.name)
                    $("#name2").html(hsl.name2)
                    $("#bla").removeClass("active")
                    $("#bla3").removeClass("active")
                    $("#bla2").addClass("active mb-2")
                    $('#name3').html("")
                    $("#displayproduct").html(html);

                }
            })
        }

        function sub_sub_category(id) {
            $.ajax({
                type: 'get',
                method: 'get',
                url: '/product/sub-sub-category/' + id,
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(hsl) {
                    var i;
                    if (hsl.record > 0) {
                        $("#search").remove();
                        $('#bla').attr('style', 'display:block')
                        $('#bla2').attr('style', 'display:block')
                        $('#bla3').attr('style', 'display:block')
                        html = '<div class="row mb-3">';
                        for (i = 0; i < hsl.record; ++i) {
                            var	number_string = hsl.data[i].harga.toString(),
                                sisa 	= number_string.length % 3,
                                rupiah 	= number_string.substr(0, sisa),
                                ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                                    
                            if (ribuan) {
                                separator = sisa ? '.' : '';
                                rupiah += separator + ribuan.join('.');
                            }
                            html = html +
                                ' <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6 mb-3">';
                            html = html + '<a href="/detil-produk/' + hsl.data[i].slug + '">';
                            html = html + '<div class="card" style="width:100% !important;">';
                            html = html + '<img src="/' + hsl.data[i].image +
                                '" class="card-img-top" alt="widget-card-2">';
                            html = html + '<div class="card-body product">';
                            html = html + '<h5 class="card-title mb-1">' + hsl.data[i].nama + '</h5>';
                            html = html + '<h5 class="mb-2"><b>Rp.' + rupiah + '</b></h5>';
                            html = html + '</div></div></a></div>';
                        }
                        html = html + '</div>';
                    } else {
                        html = '<div class="text-center mt-5">'
                            html = '<h3 class="nunito bolder">Oppss..Produk tidak ditemukan</h3>'
                            html = '<p>Silahkan gunakan kategori yang lainnya</p>'
                        html = '</div>'
                    }
                    $("#judul").html(hsl.title)
                    $("#name").html(hsl.name)
                    $("#name2").html(hsl.name2)
                    $("#name3").html(hsl.name3)
                    $("#bla").removeClass("active")
                    $("#bla2").removeClass("active")
                    $("#bla3").addClass("active mb-2")
                    $("#displayproduct").html(html);
                }
            })
        }

    </script>
@endsection
