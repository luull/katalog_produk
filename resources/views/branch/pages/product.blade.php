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
                    <li class="breadcrumb-item active" aria-current="page"><span>Daftar Produk</span></li>
                </ol>
            </nav>
        </div>
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            @if (session('message'))
                <div class="alert {{ session('color') }} alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button> {{ session('message') }}
                </div>
            @endif
            <div class="widget-content widget-content-area py-4 px-4 br-6">
                <div class="container">
                    <h3 class="text-center">DAFTAR PRODUK</h3>
                    <table id="dt-table" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Berat</th>
                                <th>Harga</th>
                                <th>Kategori</th>
                                <th>Sub Kategori</th>
                                <th>Sub Sub Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($data as $d)

                                <tr>

                                    <td><a href="/branch/detil-produk/{{ $d->slug }}" {{ $d->kode_brg }}</a></td>
                                    <td><a href="/branch/detil-produk/{{ $d->slug }}"
                                            class="text-info">{{ $d->nama }}</a></td>
                                    <td>{{ $d->berat }}</td>
                                    <td>{{ $d->harga }}</td>
                                    <td>{{ $d->category != null ? $d->category->name : '' }}</td>
                                    <td>{{ $d->sub_category != null ? $d->sub_category->name : '' }}</td>
                                    <td>{{ $d->sub_sub_category != null ? $d->sub_sub_category->name : '' }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
