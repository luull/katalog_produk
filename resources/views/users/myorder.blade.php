@extends('templates.master')
@section('content')
    <div class="container-fluid mt-5">
        @if (session('message'))
            <div class="alert alert-{{ session('alert') }} alert-dismissible fade show text-center">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span>
                </button> {!! session('message') !!}
            </div>
        @endif
        <div class="row">
            @include("users.sidebar")
            <div class="col-md-10 mb-3">
                <div class="row">
                    <div class="col-md-12 mb-5">
                        <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="blmdibayar-tab" data-toggle="tab" href="#blmdibayar"
                                    role="tab" aria-controls="blmdibayar" aria-selected="true">Belum Dibayar
                                    ({{ count_transaction(0) }})</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="dibayar-tab" data-toggle="tab" href="#dibayar" role="tab"
                                    aria-controls="dibayar" aria-selected="false">Dibayar ({{ count_transaction(1) }})</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="diproses-tab" data-toggle="tab" href="#diproses" role="tab"
                                    aria-controls="diproses" aria-selected="false">Diproses
                                    ({{ count_transaction(2) }})</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="dikemas-tab" data-toggle="tab" href="#dikemas" role="tab"
                                    aria-controls="dikemas" aria-selected="false">Dikemas ({{ count_transaction(3) }})</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="dikirim-tab" data-toggle="tab" href="#dikirim" role="tab"
                                    aria-controls="dikirim" aria-selected="false">Dikirim ({{ count_transaction(4) }})</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="diterima-tab" data-toggle="tab" href="#diterima" role="tab"
                                    aria-controls="diterima" aria-selected="false">Diterima
                                    ({{ count_transaction(5) }})</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="selesai-tab" data-toggle="tab" href="#selesai" role="tab"
                                    aria-controls="selesai" aria-selected="false">Selesai ({{ count_transaction(6) }})</a>
                            </li>
                            <?php
                            /*<li class="nav-item">
                                <a class="nav-link" id="batal-tab" data-toggle="tab" href="#batal" role="tab"
                                    aria-controls="batal" aria-selected="false">Batal ({{ count_transaction(9) }})</a>
                            </li>*/
                            ?>
                        </ul>
                        <div class="tab-content" id="simpletabContent">
                            <div class="tab-pane fade show active" id="blmdibayar" role="tabpanel"
                                aria-labelledby="blmdibayar-tab">
                                {!! transaction(0) !!}
                            </div>
                            <div class="tab-pane fade" id="dibayar" role="tabpanel" aria-labelledby="dibayar-tab">
                                {!! transaction(1) !!}
                            </div>
                            <div class="tab-pane fade" id="diproses" role="tabpanel" aria-labelledby="diproses-tab">
                                {!! transaction(2) !!}
                            </div>
                            <div class="tab-pane fade" id="dikemas" role="tabpanel" aria-labelledby="dikemas-tab">
                                {!! transaction(3) !!}

                            </div>
                            <div class="tab-pane fade" id="dikirim" role="tabpanel" aria-labelledby="dikirim-tab">
                                {!! transaction(4) !!}

                            </div>
                            <div class="tab-pane fade" id="diterima" role="tabpanel" aria-labelledby="diterima-tab">
                                {!! transaction(5) !!}

                            </div>
                            <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
                                {!! transaction(6) !!}

                            </div>

                            <?php
                            /*<div class="tab-pane fade" id="batal" role="tabpanel" aria-labelledby="batal-tab">
                                {!! transaction(9) !!}

                            </div>*/
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
