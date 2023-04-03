@extends('templates.master')
@section('content')
    <style>
        input[type="file"] {
            display: none;
        }

    </style>
    <div class="container-fluid mt-5">
        @if (session('message'))
            <div class="alert {{ session('color') }} alert-{{ session('alert') }} alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span>
                </button> {{ session('message') }}
            </div>
        @endif
        @csrf
        <div class="row">
            @include("users.sidebar")
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('update-avatar') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="text" name="id" value="{{ $data->id }}" id="" hidden>
                                    @if ($data->photo != null)
                                        <img src="{{ asset($data->photo) }}" class="img-fluid" style="max-height: 300px;"
                                            alt="">
                                        <hr>
                                        <label class="btn btn-default btn-block mb-4">
                                            <input type="file" class="form-control" name="photo">
                                            Pilih foto
                                        </label>
                                        <input type="text" value="{{ $data->photo }}" name="default" hidden>
                                        <p class="mb-0">Besar file: maksimum 2mb</p>
                                        <p>Ekstensi file yang diperbolehkan: .JPG.JPEG.PNG</p>
                                        @error('photo')
                                            <br>
                                            <div class="text-danger mt-1">Foto tidak sesuai persyaratan</div>
                                        @enderror
                                    @else
                                        <img src="{{ asset('default-user.jpeg') }}" class="img-fluid"
                                            style="max-height: 300px;" alt="">
                                        <hr>
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
                                    @endif
                                    <button type="submit" class="btn btn-success btn-block">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-12">
                                <i data-feather="user" class="mb-3"></i> {{ session('user-session')->name }}
                                <div class="card">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs  mb-3" id="simpletab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                                    role="tab" aria-controls="home" aria-selected="true">Biodata Diri</a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact"
                                                    role="tab" aria-controls="contact" aria-selected="false">Daftar
                                                    Alamat</a>
                                            </li>

                                        </ul>
                                        <div class="tab-content" id="simpletabContent">
                                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                                aria-labelledby="home-tab">
                                                <form action="{{ route('update-avatar') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="text" name="id" value="{{ $data->id }}" id="" hidden>
                                                    <div class="row mb-4">
                                                        <div class="col-md-12">
                                                            <h3 class="semi-bolder size-14 text-muted">Ubah Biodata Diri
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-md-3">
                                                            <p>Nama</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="name"
                                                                value="{{ $data->name }}">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-md-3">
                                                            <p>Email</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="email"
                                                                value="{{ $data->email }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-md-3">
                                                            <p>Handphone</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="phone"
                                                                value="{{ $data->phone }}" readonly>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="contact" role="tabpanel"
                                                aria-labelledby="contact-tab">
                                                @if ($countcontact == null)
                                                    <button class="btn btn-success" data-toggle="modal"
                                                        data-target="#address">Aktivasi Alamat</button>
                                                @else
                                                    <button class="btn btn-success mb-3" style="float: right"
                                                        data-toggle="modal" data-target="#address">Tambah Alamat</button>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            @foreach ($contact as $c)
                                                                @if ($c->status == 1)
                                                                    <div class="infobox-3"
                                                                        style="background-color:#f3fff4bd;border:1px solid green">
                                                                    @else
                                                                        <div class="infobox-3">
                                                                @endif
                                                                @if ($c->status == 1)
                                                                    <div class="info-icon">
                                                                        <i data-feather="map-pin"
                                                                            style="max-height:50px;"></i> <span
                                                                            style="color: #fff;">Utama</span>
                                                                    </div>
                                                                @endif
                                                                <div class="row">
                                                                    <div class="col-md-10">
                                                                        <p class="size-16">{{ $c->category }}</p>
                                                                        <p class="size-18">{{ $c->name }}</p>
                                                                        <p class="info-text">{{ $c->address }},
                                                                            {{ $c->province }}, {{ $c->type }}
                                                                            {{ $c->city_name }},
                                                                            {{ $c->subdistrict_name }} -
                                                                            {{ $c->kd_pos }}</p>
                                                                        <a class="info-link edit " style="cursor:pointer"
                                                                            id="e-{{ $c->idny }}"><b>Ubah
                                                                                Alamat</b></a> | <a class="info-link"
                                                                            href="/deletecontact/{{ $c->idny }}"><b>Hapus</b></a>
                                                                    </div>
                                                                    @if ($c->status != 1)
                                                                        <div class="col-md-2">
                                                                            <div class="align-self-center">
                                                                                <br>
                                                                                <form
                                                                                    action="{{ route('update-status') }}"
                                                                                    method="post"
                                                                                    enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    <input type="text"
                                                                                        value="{{ $c->idny }}"
                                                                                        name="id" hidden>
                                                                                    <button
                                                                                        class="btn btn-success align-self-center">Pilih</button>
                                                                                </form>
                                                                            </div>

                                                                        </div>
                                                                    @endif
                                                                </div>
                                                        </div>
                                                @endforeach
                                            </div>

                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="address" tabindex="-1" role="dialog" aria-labelledby="addressLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addressLabel">Tambah Alamat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <form action="{{ route('add-contact') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>Nama Alamat/Penerima</label>
                                    @php
                                        if (empty(old('name'))) {
                                            $penerima = session('user-session')->name;
                                            $phone = session('user-session')->phone;
                                        } else {
                                            $penerima = old('name');
                                            $phone = old('phone');
                                        }
                                    @endphp
                                    <input type="text" class="form-control" name="penerima" max="30"
                                        value="{{ $penerima }}">
                                    <br>
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>Kategori Alamat</label>
                                    <br>
                                    <select name="category" class="form-control" required>
                                        <option value="rumah">Rumah</option>
                                        <option value="kantor">Kantor</option>
                                        <option value="toko">Toko</option>
                                    </select>
                                    <br>
                                    @error('category')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Propinsi</label>
                                    <select name="propinsi" id="propinsi" class="form-control"
                                        value="{{ old('propinsi') }}" required>
                                        @foreach ($province as $prov)
                                            <option value="{{ $prov->province }}">{{ $prov->province }}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    @error('propinsi')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Kota</label>
                                    <select id="kota" name="kota" class="form-control" value="{{ old('kota') }}"
                                        required>

                                    </select>
                                    <br>
                                    @error('kota')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label>Kecamatan</label>
                                    <select id="kecamatan" name="kecamatan" class="form-control"
                                        value="{{ old('kecamatan') }}" required>

                                    </select>
                                    <br>
                                    @error('kecamatan')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>Kode Pos</label>
                                    <input type="text" name="kd_pos" class="form-control" value="{{ old('kd_pos') }}"
                                        required>
                                    <br>
                                    @error('kd_pos')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>No Handphone</label>
                                    <input type="text" class="form-control" name="phone" max="12"
                                        value="{{ $phone }}">
                                    <br>
                                    @error('phone')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>Alamat</label>
                                    <textarea name="alamat" id="" cols="5" rows="4" class="form-control"></textarea>
                                    <br>
                                    @error('alamat')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="editaddress" tabindex="-1" role="dialog" aria-labelledby="editaddressLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editaddressLabel">Edit Alamat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <form action="{{ route('update-contact') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>Nama Alamat/Penerima</label>
                                    @php
                                        if (empty(old('name'))) {
                                            $penerima = session('user-session')->name;
                                            $phone = session('user-session')->phone;
                                        } else {
                                            $penerima = old('name');
                                            $phone = old('phone');
                                        }
                                    @endphp
                                    <input type="text" class="form-control" id="edit_penerima" name="edit_penerima" max="30"
                                        value="{{ $penerima }}">
                                    <br>
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>Kategori Alamat</label>
                                    <br>
                                    <select name="category" id="edit_category" class="form-control" required>
                                        <option id="edit_category" value="rumah">Rumah</option>
                                        <option id="edit_category" value="kantor">Kantor</option>
                                        <option id="edit_category" value="toko">Toko</option>
                                    </select>
                                    <br>
                                    @error('category')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Propinsi</label>
                                    <select name="propinsi" id="edit_propinsi" class="edit_propinsi form-control"
                                        value="{{ old('propinsi') }}" required>
                                        @foreach ($province as $prov)
                                            <option value="{{ $prov->province }}">{{ $prov->province }}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    @error('propinsi')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Kota</label>
                                    <select id="edit_kota" name="kota" class="edit_kota form-control"
                                        value="{{ old('kota') }}" required>

                                    </select>
                                    <br>
                                    @error('kota')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label>Kecamatan</label>
                                    <select id="edit_kecamatan" name="kecamatan" class="edit_kecamatan form-control"
                                        value="{{ old('kecamatan') }}" required>

                                    </select>
                                    <br>
                                    @error('edit_kecamatan')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>Kode Pos</label>
                                    <input type="text" name="kd_pos" id="edit_kd_pos" class="form-control"
                                        value="{{ old('kd_pos') }}" required>
                                    <br>
                                    @error('edit_kd_pos')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>No Handphone</label>
                                    <input type="text" class="form-control" id="edit_phone" name="phone" max="12"
                                        value="{{ $phone }}">
                                    <br>
                                    @error('edit_phone')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>Alamat</label>
                                    <textarea name="alamat" id="edit_alamat" cols="5" rows="4"
                                        class="form-control"></textarea>
                                    <br>
                                    @error('alamat')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#propinsi").change(function() {
                var propinsi = $("#propinsi").val();
                $.ajax({
                    type: 'get',
                    method: 'get',
                    url: '/city/find/' + propinsi,
                    data: '_token = <?php echo csrf_token(); ?>',
                    success: function(hsl) {
                        if (hsl.code == 404) {
                            alert(hsl.error);

                        } else {
                            var data = [];
                            data = hsl.result;
                            $("#kota").children().remove().end();
                            $.each(data, function(i, item) {
                                $("#kota").append('<option value="' + item.city_id +
                                    '">' + item.city_name + ' ' + item.type +
                                    '</option>');
                            })
                            kecamatan();
                            $("#kota").focus();

                        }
                    }
                });
            })
            $("#kota").change(function() {
                kecamatan();
            })
        })

        function kecamatan() {
            var kota = $("#kota").val();
            $.ajax({
                type: 'get',
                method: 'get',
                url: '/subdistrict/find/' + kota,
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(hsl) {
                    if (hsl.code == 404) {
                        alert(hsl.error);

                    } else {
                        var data = [];
                        data = hsl.result;
                        console.log(hsl.result)
                        $("#kecamatan").children().remove().end();
                        $.each(data, function(i, item) {
                            $("#kecamatan").append('<option value="' + item.subdistrict_id + '">' + item
                                .subdistrict_name + '</option>');
                        })
                        $("#kecamatan").focus();

                    }
                }
            });
        }
        $(".edit").click(function() {
            var idnya = $(this).attr('id').split('-');
            var id = idnya[1];
            $.ajax({
                type: 'get',
                method: 'get',
                url: '/contact/find/' + id,
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(hsl) {
                    if (hsl.error) {
                        alert(hsl.message);
                    } else {
                        $("#edit_id").val(id);
                        $("#edit_penerima").val(hsl.name);
                        $("#edit_category").val(hsl.category);
                        //  $("#edit_propinsi").val(hsl.province);
                        propinsi2(hsl.province, hsl.city);
                        kecamatan2(hsl.city, hsl.subdistrict);
                        //  $("#edit_kota").val(hsl.city);
                        // $("#edit_kecamatan").val(hsl.subdistrict);
                        $("#edit_kd_pos").val(hsl.kd_pos);
                        $("#edit_phone").val(hsl.phone);
                        $("textarea#edit_alamat").val(hsl.address);
                        $("#editaddress").modal();
                    }
                }
            });

        })


        function propinsi2(id, kota) {

            // var propinsi = $("#edit_propinsi").val();
            var propinsi = id;
            $.ajax({
                type: 'get',
                method: 'get',
                url: '/city/find/' + propinsi,
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(hsl) {
                    if (hsl.code == 404) {
                        alert(hsl.error);

                    } else {
                        var data = [];
                        data = hsl.result;
                        $("#edit_kota").children().remove().end();
                        $.each(data, function(i, item) {
                            if (item.city_id == kota) {
                                $("#edit_kota").append('<option class="edit_kota" value="' + item
                                    .city_id + '" selected>' + item.city_name + ' ' + item.type +
                                    '</option>');

                            } else {
                                $("#edit_kota").append('<option class="edit_kota" value="' + item
                                    .city_id + '">' + item.city_name + ' ' + item.type + '</option>'
                                    );

                            }
                        })
                        kecamatan2();
                        $("#edit_kota").focus();

                    }
                }
            });
        }

        function kecamatan2(kota, kec) {
            //var kota = $("#edit_kota").val();
            $.ajax({
                type: 'get',
                method: 'get',
                url: '/subdistrict/find/' + kota,
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(hsl) {
                    if (hsl.code == 404) {
                        alert(hsl.error);

                    } else {
                        var data = [];
                        data = hsl.result;
                        $("#edit_kecamatan").children().remove().end();
                        $.each(data, function(i, item) {
                            if (item.subdistrict_id == kec) {
                                $("#edit_kecamatan").append('<option class="edit_kecamatan" value="' +
                                    item.subdistrict_id + '" selected>' + item.subdistrict_name +
                                    '</option>');

                            } else {
                                $("#edit_kecamatan").append('<option class="edit_kecamatan" value="' +
                                    item.subdistrict_id + '">' + item.subdistrict_name + '</option>'
                                    );

                            }
                        })
                        $("#edit_kecamatan").focus();

                    }
                }
            });
        }

    </script>
@stop
