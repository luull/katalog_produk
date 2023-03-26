@extends('templates.master')
@section('content')

    <div class="container-fluid mt-5">


        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-five">
                    <ul class="breadcrumb">
                        <li class="active mb-2"><a href="/">Beranda</a>
                        </li>
                        <li class="mb-2"><a href="/pages/{{ $data->slug }}">{{ $data->title }}</a></li>

                    </ul>
                </div>
            </div>
            <?php $col = 12; ?>
            @if ($data->image != null)
                <div class="col-md-4">
                    <hr>
                    <div class="text-center">
                        <img src="{{ asset($data->image) }}" class="img-fluid" style="width:300px;" alt="">
                    </div>
                </div>
                <?php $col = 8; ?>
            @endif
            <div class="col-md-{{ $col }} mb-3">
                <hr>
                <h3 class="nunito bolder mb-2">{{ $data->title }} </h3>
                <p>&nbsp;</p>
                <p class="mb-4">
                    {!! $data->content !!}
                </p>


            </div>

        </div>
    </div>

    </div>

@endsection
@section('script')

@endsection
