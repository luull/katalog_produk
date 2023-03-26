@extends('branch.templates.master')
@section('style')
    <link href="{{ asset('templates/plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">


@endsection
@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span>Data Transaksi Per Bulan</span></li>
                </ol>
            </nav>
        </div>
        <div class="col-xl-12 col-md-12 col-sm-12  layout-spacing">
            @if (session('message'))
                <div class="alert alert-{{ session('alert') }} alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button> {{ session('message') }}
                </div>
            @endif
            <div class="widget-content widget-content-area py-4 px-4 br-6">
                <div class="container">
                    <form action="{{ route('process-transaction-by-month') }}" method="POST">
                        @csrf
                        <div class="card col-md-12">

                            <div class="card-body">
                                <h4>Data Transaction Per Bulan </h4>
                                <hr>
                                <div class="row">

                                    <div class="col-md-12">
                                        <label>Periode</label>
                                        <div class="input-group mb-1">
                                            <select name="bln" id="bln"
                                                class="@error('bln') is-invalid @enderror form-control select2bs4 form-control-xs"
                                                required>
                                                @for ($bln = 0; $bln <= 12; $bln++)
                                                    <option value="{{ $bln }}"
                                                        {{ $bln == date('m') ? 'selected' : '' }}>{{ bulan($bln) }}
                                                    </option>
                                                @endfor

                                            </select> &nbsp;
                                            <select name="thn" id="thn"
                                                class="@error('thn') is-invalid @enderror form-control select2bs4 form-control-xs"
                                                required>
                                                @for ($thn = 2020; $thn < 2050; $thn++)
                                                    <option value="{{ $thn }}"
                                                        {{ $thn == date('Y') ? 'selected' : '' }}>{{ $thn }}
                                                    </option>
                                                @endfor

                                            </select>
                                        </div>
                                        @error('bln')
                                            <br>
                                            <div class="text-danger mt-1">{{ message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <hr>
                                <button type="submit" class="btn btn-primary">Process</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')


    <script src="{{ asset('templates/plugins/flatpickr/flatpickr.js') }}"></script>
    <script>
        var f3 = flatpickr(document.getElementById('rangeCalendarFlatpickr'), {
            dateFormat: "d-m-Y",
            mode: "range"
        });

    </script>

@endsection
