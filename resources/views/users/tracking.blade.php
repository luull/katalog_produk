@extends('templates.master')
@section('content')
<div class="container-fluid mt-5">
    @if (session('message'))
    <div class="alert alert-{{ session('alert')}} alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button> {{ session('message') }}</div>
    @endif
<div class="row">
    
    @include("users.sidebar")
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-12 mb-5">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <a href="/myorder#dikirim" style="float: left"><i class="fa fa-angle-left"></i> Kembali</a>
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
                            <div class="item-timeline">
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
