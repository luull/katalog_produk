@extends('backend.templates.master')
@section('style')
    <link href="{{ asset('templates/assets/css/components/timeline/custom-timeline.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Trancking</span></li>
            </ol>
        </nav>
    </div>
    <div class="col-xl-12 col-md-12 col-sm-12  layout-spacing">
        @if (session('message'))
        <div class="alert alert-{{ session('alert') }} alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button> {{ session('message') }}</div>
        @endif
        <div class="widget-content widget-content-area py-4 px-4 br-6">
           <div class="container">
               <div class="card">
                    <div class="card-body">
                        <div class="card-header bg-white">
                            <a href="/backend/dashboard" class="btn btn-success style="float: left"> Kembali</a>
                            <p style="float: right">{{$idtrans}}</p>
                            <br>
                            <hr>
                            <p style="float: right"><strong>No Resi : {{$noresi}}</strong></p>
                            @if ($data_paket)
                          
                            <p class="mb-0">Dikirim dengan  {{$data_paket['courier_name']}} ({{$data_paket['service_code']}})</p>
                           @if ($data_paket['status'] != "ON PROCESS")
                           <p><strong>PESANAN TELAH DITERIMA OLEH {{$data_status['pod_receiver']}}</strong></p>
                           @else
                           <p class="mb-0">Estimasi Kedatangan {{$etd->etd}} Hari</p>
                           @endif
                           @else 
                           <div class="alert alert-danger text-center">
                               No Resi : {{$noresi}} tidak ditemukan
                           </div>
                           @endif
                        </div>
                        @if ($data_resi)
                        <div class="timeline-line">
                            @foreach ($data_resi as $key => $r )
                            <div class="item-timeline" >
                                <p class="t-time"> <small><strong>{{date('H:i', strtotime($r['manifest_time'])) }}</strong> </small></p>

                                @if ($data_paket['status'] != "ON PROCESS")
                                    <div class="t-dot t-dot-success">
                                    </div>
                                @elseif ($key == 0)
                                    <div class="t-dot t-dot-info">
                                    </div>
                                @else
                                    <div class="t-dot t-dot-dark">
                                    </div>
                                @endif
                                <div class="t-text">
                                    <p> {{$r['manifest_description']}}</p>
                                    <p class="t-meta-time"> {{$r['city_name']}}</p>
                                    <small>{{$r['manifest_date']}}</small>
                                </div>
                                <hr>
                            </div>
                            @endforeach

                        </div>
                      @endif
                    </div>
                </div>
           </div>
        </div>
    </div>
</div>
@endsection