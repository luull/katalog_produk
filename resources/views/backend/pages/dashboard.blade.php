@extends('backend.templates.master')
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
        <ul class="nav nav-tabs col-12 bg-light mt-3 " id="simpletab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="daftarorder-tab" data-toggle="tab" href="#daftarorder" role="tab"
                    aria-controls="daftarorder" aria-selected="true">Daftar Order Customer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="daftarcustomer-tab" data-toggle="tab" href="#daftarcustomer" role="tab"
                    aria-controls="daftarcustomer" aria-selected="false">Daftar Customer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="daftarcustomer1-tab" data-toggle="tab" href="#daftarcustomer1" role="tab"
                    aria-controls="daftarcustomer1" aria-selected="false">Daftar Customer Hari Ini</a>
            </li>
        </ul>
        <div class="tab-content p-1 " style="border:1px solid #eee;overflow:auto !important;" id="simpletabContent">
            <div class="tab-pane fade show active" id="daftarorder" role="tabpanel" aria-labelledby="daftarorder-tab">
                <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="blmdibayar-tab" data-toggle="tab" href="#blmdibayar" role="tab"
                            aria-controls="blmdibayar" aria-selected="true">Belum Dibayar
                            ({{ count_transaction_backend(0) }})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="dibayar-tab" data-toggle="tab" href="#dibayar" role="tab"
                            aria-controls="dibayar" aria-selected="false">Dibayar ({{ count_transaction_backend(1) }})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="diproses-tab" data-toggle="tab" href="#diproses" role="tab"
                            aria-controls="diproses" aria-selected="false">Diproses
                            ({{ count_transaction_backend(2) }})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="dikemas-tab" data-toggle="tab" href="#dikemas" role="tab"
                            aria-controls="dikemas" aria-selected="false">Dikemas ({{ count_transaction_backend(3) }})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="dikirim-tab" data-toggle="tab" href="#dikirim" role="tab"
                            aria-controls="dikirim" aria-selected="false">Dikirim ({{ count_transaction_backend(4) }})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="sampai-tab" data-toggle="tab" href="#sampai" role="tab"
                            aria-controls="sampai" aria-selected="false">Sampai ({{ count_transaction_backend(5) }})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="selesai-tab" data-toggle="tab" href="#selesai" role="tab"
                            aria-controls="selesai" aria-selected="false">Selesai ({{ count_transaction_backend(6) }})</a>
                    </li>
                    <?php
                    /* <li class="nav-item">
                        <a class="nav-link" id="batal-tab" data-toggle="tab" href="#batal" role="tab" aria-controls="batal"
                            aria-selected="false">Batal ({{ count_transaction_backend(9) }})</a>
                    </li>*/
                    ?>
                </ul>
                <div class="tab-content col-12" id="simpletabContent" style="min-height:200px !important">
                    <div class="tab-pane fade show active" id="blmdibayar" role="tabpanel" aria-labelledby="blmdibayar-tab">
                        {!! transaction_backend(0) !!}

                    </div>
                    <div class="tab-pane fade" id="dibayar" role="tabpanel" aria-labelledby="dibayar-tab">
                        {!! transaction_backend(1) !!}
                    </div>
                    <div class="tab-pane fade" id="diproses" role="tabpanel" aria-labelledby="diproses-tab">
                        {!! transaction_backend(2) !!}
                    </div>
                    <div class="tab-pane fade " id="dikemas" role="tabpanel" aria-labelledby="dikemas-tab">
                        {!! transaction_backend(3) !!}

                    </div>
                    <div class="tab-pane fade" id="dikirim" role="tabpanel" aria-labelledby="dikirim-tab">
                        {!! transaction_backend(4) !!}

                    </div>
                    <div class="tab-pane fade" id="sampai" role="tabpanel" aria-labelledby="sampai-tab">
                        {!! transaction_backend(5) !!}

                    </div>
                    <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
                        {!! transaction_backend(6) !!}

                    </div>
                    <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
                        {!! transaction_backend(7) !!}

                    </div>
                    <?php
                    /*<div class="tab-pane fade" id="batal" role="tabpanel" aria-labelledby="batal-tab">
                        {!! transaction_backend(9) !!}

                    </div>*/
                    ?>

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


    <div class="modal fade" id="MyModal" tabindex="-1" role="dialog" aria-labelledby="MyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="MyModalLabel">Bukti Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="myModalContent">
                            <img class="img img-fluid" id="my_image">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn " data-dismiss="modal"> Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        function bukti_bayar(id) {
            $.ajax({
                type: 'get',
                method: 'get',
                url: '/bukti-pembayaran/' + id,
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(hsl) {
                    if (hsl.length) {
                        $("#my_image").attr("src", "/" + hsl);
                    }
                }
            });


            $('#MyModal').modal('show');
        }

    </script>

@endsection
