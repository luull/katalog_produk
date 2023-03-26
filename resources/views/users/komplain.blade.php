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
            <div class="col-md-2"></div>
            <div class="col-md-10 mb-3">
                <div class="row">
                    <div class="col-md-12 mb-5">
                        Form Komplain
                    </div>
                </div>
            </div>
        </div>
    @endsection
