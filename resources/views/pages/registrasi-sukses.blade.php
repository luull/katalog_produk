@extends('templates.master')
@section('content')

    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div clas="col-12">
                <h4 class="nunito bolder mb-4 text-center">Selemat {{ $nama }}, proses pendaftaran Anda di
                    {{ env('STORE_NAME') }} sukses, dengan data-data sebagai berikut: </h4>
                <table cellpadding=4 cellspacing=0 border=1 align="center" style="width:500px;margin:20px auto">
                    <tr>
                        <td>Username </td>
                        <td>{{ $data['username'] }}</td>
                    </tr>
                    <tr>
                        <td>Password </td>
                        <td>{{ $data['password'] }}</td>
                    </tr>
                    <tr>
                        <td>Nama Lengkap </td>
                        <td>{{ $data['nama'] }}</td>
                    </tr>
                    <tr>
                        <td>Alamat Email </td>
                        <td>{{ $data['email'] }}</td>
                    </tr>
                    <tr>
                        <td>No Handphone </td>
                        <td>{{ $data['phone'] }}</td>
                    </tr>
                    <tr>
                        <td>Refferal </td>
                        <td>{{ $data['refferal'] }}</td>
                    </tr>
                    <tr>
                        <td>No HP Refferal</td>
                        <td>{{ $data['hp_refferal'] }}</td>
                    </tr>
                </table>
                @php
                    $url_konfirmasi = encrypt($data['email'] . '&' . $data['id_user']);
                @endphp
                <h4 class="nunito bolder mb-4 text-center">Silahkan lakukan Konfirmasi dengan mengklik tombol <a
                        href="{{ env('APP_DOMAIN') }}/confirm/{{ $url_konfirmasi }}"
                        style="text-decoration:none;color:red;" target="_blank">Konfirmasi</a> untuk
                    mengkonfirmasi proses pendaftaran Anda </h4>
                <div class="alert alert-success text-center">
                    Selemat {{ $nama }}, proses pendaftaran Anda di {{ env('STORE_NAME') }} sukses,<br>
                    Silahkan lakukan konfirmasi dengan mengklik tombol konfirmasi di email yang telah kami kirim</div>


            </div>
        </div>

    </div>

@endsection
