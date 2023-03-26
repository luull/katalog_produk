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
                    <li class="breadcrumb-item active" aria-current="page"><a
                            href="/branch/transaction"><span>Transaction</span></a>
                    </li>
                    @if ($jenis == 'perTgl')
                        <li class="breadcrumb-item active" aria-current="page"><span>Per Tanggal</span>
                        </li>
                    @endif

                </ol>
            </nav>
        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="row justify-content-center">


                @if (session('message'))
                    <div class="alert alert-{{ session('alert') }} text-center">{{ session('message') }}</div>
                @endif
                <h4 class="text-center " style="text-align:center">{!! $judul !!}</h4>

                <DIV class="table-responsive">
                    <table id="dt-table" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No Trans</th>
                                <th>Tgl Trans</th>
                                <th>Customer</th>
                                <th>Sub Total</th>
                                <th>Ongkir</th>
                                <th>Total</th>
                                <th>Kode Unik</th>
                                <th>Total Bayar</th>
                                <th>Pembayaran</th>
                                <th>Kurir</th>
                                <th>Status</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $dt)
                                <tr>
                                    <td>{{ $dt->id_transaction }}</td>
                                    <td>{{ $dt->date_created }}</td>
                                    <td>{{ $dt->name }}</td>
                                    <td align="right">{{ number_format($dt->sub_total) }}</td>
                                    <td align="right">{{ number_format($dt->total_ongkir) }}</td>
                                    <td align="right">{{ number_format($dt->total) }}</td>
                                    <td align="right">{{ number_format($dt->unix_code) }}</td>
                                    <td align="right">{{ number_format($dt->total_bayar) }}</td>


                                    <td>{{ $dt->bank }}-{{ $dt->no_rek }} </td>
                                    <td>{{ $dt->kurir }} </td>
                                    <th>{{ keterangan_status($dt->status) }}</th>




                                </tr>

                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>

        </div>
        <a href="javascript:history.back(-1)" class="btn btn-info btn-sm ml-3">Kembali</a>
    </div>
    </div>
@endsection
