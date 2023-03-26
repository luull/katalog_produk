@extends('templates.master')
@section('content')
    <div class="container-fluid mt-5">

        <div class="row">
            @include("users.sidebar")
            <div class="col-md-10 mb-3">
                <div class="row">
                    <div class="col-md-6 mb-5">

                        <div class="card">
                            <div class="card-header">
                                <div class="card-title p-2 mt-3 text-center">
                                    <h4>Kirim Bukti Pembayaran</h4>
                                </div>
                                <hr>
                            </div>
                            <div class="card-body">

                                <form action="{{ route('kirim_bukti_pembayaran') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="text" name="id" value="{{ $no_trans }}" id="" hidden>


                                    <label class="btn btn-default btn-block mb-4">
                                        <input type="file" class="form-control" name="photo">
                                        Pilih foto
                                    </label>
                                    <p class="mb-0">Besar file: maksimum 2mb</p>
                                    <p>Ekstensi file yang diperbolehkan: .JPG.JPEG.PNG</p>
                                    @error('photo')
                                        <br>
                                        <div class="text-danger mt-1">Foto tidak sesuai persyaratan</div>
                                    @enderror

                                    <button type="submit" class="btn btn-success btn-block">Proses</button>
                                </form>
                            </div>
                            @if (session('message'))
                                <div class="card-footer">
                                    <div
                                        class="alert alert-{{ session('alert') }} alert-dismissible fade show text-center">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                                aria-hidden="true">&times;</span>
                                        </button> {!! session('message') !!}
                                    </div>
                                </div>

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
