@extends('branch.templates.master')
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
                    <li class="breadcrumb-item active" aria-current="page"><span>Pengiriman</span></li>
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
                    <form action="{{ route('branch-proses-kirim') }}" method="POST">
                        @csrf
                        <div class="card col-md-6">

                            <div class="card-body">
                                <h4>Proses Pengiriman</h4>
                                <hr>
                                <div class="row">

                                    <div class="col-md-12">
                                        <label>Nomor Resi</label>
                                        <input type="text" class="form-control" name="resi">
                                        <input type="hidden" class="form-control" name="id" value="{{ $id }}">
                                        @error('resi')
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
