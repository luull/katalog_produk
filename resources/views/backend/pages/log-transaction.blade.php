@extends('backend.templates.master')
@section('content')
    <div class="container-fluid mt-5">
        @if (session('message'))
            <div class="alert alert-{{ session('alert') }} alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span>
                </button> {{ session('message') }}
            </div>
        @endif
        <div class="row">

            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-12 mb-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header">
                                    <a href="javascript:history.back(-1)" style="float: left"><i
                                            data-feather="arrow-left-circle"></i>
                                        Kembali</a>
                                    <p style="float: right">Log Transaksi<br><br><strong>No Transaksi :
                                            {{ $id_transaksi }}</strong></p>
                                    <br>
                                    <hr>


                                </div>
                                @if ($data)
                                    <div class="timeline-line">
                                        @foreach ($data as $dt)
                                            <div class="item-timeline">
                                                <p class="t-time">
                                                    <small><strong>{{ substr($dt->created_at, 11, 10) }}</strong> </small>
                                                </p>

                                                <div class="ml-3 t-dot t-dot-success">
                                                </div>
                                                <div class="t-text">
                                                    <p> {{ $dt['description'] }}</p>
                                                    <small class="text-secondary small">
                                                        {{ $dt['created_by'] . '@' . $dt['menu'] }}</small><br>
                                                    <small>{{ substr($dt['created_at'], 0, 10) }}</small>
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
