@extends('branch.templates.master')
@section('content')
    <div class="row layout-top-spacing">
        <!--<div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                                                                        <div class="widget widget-chart-one">
                                                                            <div class="widget-heading">
                                                                                <h5 class="">Revenue</h5>
                                                                                <div class="task-action">
                                                                                    <div class="dropdown">
                                                                                        <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                                                        </a>
                                                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask" style="will-change: transform;">
                                                                                            <a class="dropdown-item" href="javascript:void(0);">Weekly</a>
                                                                                            <a class="dropdown-item" href="javascript:void(0);">Monthly</a>
                                                                                            <a class="dropdown-item" href="javascript:void(0);">Yearly</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="widget-content">
                                                                                <div id="revenueMonthly"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                                                                        <div class="widget widget-chart-two">
                                                                            <div class="widget-heading">
                                                                                <h5 class="">Sales by Category</h5>
                                                                            </div>
                                                                            <div class="widget-content">
                                                                                <div id="chart-2" class=""></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>-->
        @if (session('message'))
            <div class="col-12 p-3 alert alert-{{ session('alert') }} text-center">{{ session('message') }}</div>
        @endif

        <div class="tab-content p-1 " style="border:1px solid #eee;overflow:auto !important" id="simpletabContent">
            <div class="tab-pane fade show active" id="daftarorder" role="tabpanel" aria-labelledby="daftarorder-tab">
                <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link " id="blmdibayar-tab" data-toggle="tab" href="#blmdibayar" role="tab"
                            aria-controls="blmdibayar" aria-selected="false">Belum Dibayar
                            ({{ count_transaction_branch(0) }})</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" id="dibayar-tab" data-toggle="tab" href="#dibayar" role="tab"
                            aria-controls="dibayar" aria-selected="true">Dibayar ({{ count_transaction_branch(1) }})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="diproses-tab" data-toggle="tab" href="#diproses" role="tab"
                            aria-controls="diproses" aria-selected="false">Diproses
                            ({{ count_transaction_branch(2) }})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="dikemas-tab" data-toggle="tab" href="#dikemas" role="tab"
                            aria-controls="dikemas" aria-selected="false">Dikemas ({{ count_transaction_branch(3) }})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="dikirim-tab" data-toggle="tab" href="#dikirim" role="tab"
                            aria-controls="dikirim" aria-selected="false">Dikirim ({{ count_transaction_branch(4) }})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="sampai-tab" data-toggle="tab" href="#sampai" role="tab"
                            aria-controls="sampai" aria-selected="false">Sampai ({{ count_transaction_branch(5) }})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="selesai-tab" data-toggle="tab" href="#selesai" role="tab"
                            aria-controls="selesai" aria-selected="false">Selesai ({{ count_transaction_branch(6) }})</a>
                    </li>

                </ul>
                <div class="tab-content col-12" id="simpletabContent" style="min-height:300px !important">
                    <div class="tab-pane fade " id="blmdibayar" role="tabpanel" aria-labelledby="blmdibayar-tab">
                        {!! transaction_branch(0) !!}

                    </div>
                    <div class="tab-pane fade show active" id="dibayar" role="tabpanel" aria-labelledby="dibayar-tab">
                        {!! transaction_branch(1) !!}
                    </div>
                    <div class="tab-pane fade" id="diproses" role="tabpanel" aria-labelledby="diproses-tab">
                        {!! transaction_branch(2) !!}
                    </div>
                    <div class="tab-pane fade " id="dikemas" role="tabpanel" aria-labelledby="dikemas-tab">
                        {!! transaction_branch(3) !!}

                    </div>
                    <div class="tab-pane fade" id="dikirim" role="tabpanel" aria-labelledby="dikirim-tab">
                        {!! transaction_branch(4) !!}

                    </div>
                    <div class="tab-pane fade" id="sampai" role="tabpanel" aria-labelledby="sampai-tab">
                        {!! transaction_branch(5) !!}

                    </div>
                    <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
                        {!! transaction_branch(6) !!}

                    </div>


                </div>
            </div>
            <div class="tab-pane fade col-12 mt-1" style="overflow:auto" id="daftarcustomer" role="tabpanel"
                aria-labelledby="daftarcustomer-tab">
                {!! daftar_customer() !!}
            </div>
            <div class="tab-pane fade col-12 mt-1" style="overflow:auto" id="daftarcustomer1" role="tabpanel"
                aria-labelledby="daftarcustomer1-tab">

                {!! daftar_customer1('', '') !!}
            </div>
        </div>
    </div>


@endsection
