@extends('backend.templates.master')
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
                    <li class="breadcrumb-item active" aria-current="page"><span>product</span></li>
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
                    <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#addModal">Create</button>
                    <table id="dt-table" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Stok</th>
                                <th>Berat</th>
                                <th>Harga</th>
                                <th>Kategori</th>
                                <th>Sub Kategori</th>
                                <th>Sub Sub Kategori</th>
                                <th>Date created</th>
                                <th>Created by</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($data as $d)

                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td><img src="{{ asset($d->image) }}" style="max-height: 70px;"
                                            alt="{{ asset($d->image) }}"></td>
                                    <td>{{ $d->kode_brg }}</td>
                                    <td>{{ $d->nama }}</td>
                                    <td>{{ $d->stok }}</td>
                                    <td>{{ $d->berat }}</td>
                                    <td>{{ $d->harga }}</td>
                                    <td>{{ $d->category != null ? $d->category->name : '' }}</td>
                                    <td>{{ $d->sub_category != null ? $d->sub_category->name : '' }}</td>
                                    <td>{{ $d->sub_sub_category != null ? $d->sub_sub_category->name : '' }}</td>
                                    <td>{{ $d->date_created }}</td>
                                    <td>{{ $d->created_by }}</td>
                                    <td>
                                        <a href="#" class="edit" onclick="edit({{ $d->id }})"
                                            id="e-{{ $d->id }}" alt="Edit"><i data-feather="edit"></i></a>
                                        <a href="/backend/product/delete/{{ $d->id }}" alt="Delete"><i
                                                data-feather="trash" class="text-danger"></i></a>
                                        <a href="/backend/detil-produk/{{ $d->slug }}" alt="Detil Produk"><i
                                                data-feather="eye" class="text-info"></i></a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Add-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Create product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="close"></i>
                    </button>
                </div>
                <form action="{{ route('create-product') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kode Produk</label>
                                    <input type="text" class="form-control" value="{{ old('kode_brg') }}"
                                        name="kode_brg">
                                    @error('kode_brg')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input type="text" class="form-control" name="nama" value="{{ old('nama') }}">
                                    @error('nama')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Berat</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="berat" class="form-control" value="{{ old('berat') }}">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Gram</span>
                                    </div>
                                    @error('berat')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Stok</label>
                                <div class="form-group mb-3">
                                    <input type="number" name="stok" class="form-control" value="{{ old('stok') }}">
                                    @error('stok')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Satuan</label>
                                <div class="input-group mb-3">
                                    <select name="satuan" id="satuan" class="form-control">
                                        @foreach ($satuan as $s)
                                            <option value="{{ $s->nama }}">{{ $s->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('satuan')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Harga</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    </div>
                                    <input type="number" name="harga" class="form-control" value="{{ old('harga') }}">
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="kategori" id="kategori" class="form-control">
                                        <option value="">Silahkan Pilih</option>
                                        @foreach ($category as $c)
                                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sub Kategori</label>
                                    <select name="sub_kategori" id="sub_category" class="form-control">

                                    </select>
                                    @error('sub_kategori')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sub Sub Kategori</label>
                                    <select name="sub_sub_kategory" id="sub_sub_category" class="form-control">

                                    </select>
                                    @error('sub_sub_kategory')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Keterangan singkat</label>
                                    <textarea class="form-control" name="keterangan_singkat" rows="4" cols="8"></textarea>
                                    @error('keterangan_singkat')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea id="body" class="form-control" name="keterangan" rows="10"
                                        cols="50"></textarea>
                                    @error('keterangan')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label>Image</label>
                                <span class="text-danger">* max size 2mb</span>
                                <input type="file" class="form-control" name="image">
                                @error('image')
                                    <br>
                                    <div class="text-danger mt-1">{{ message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal edit-->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="close"></i>
                    </button>
                </div>
                <form action="{{ route('update-product') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="id" id="edit_id" hidden>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kode Produk</label>
                                    <input type="text" class="form-control" value="{{ old('edit_kode_brg') }}"
                                        name="edit_kode_brg" id="edit_kode_brg">
                                    @error('edit_kode_brg')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input type="text" id="edit_nama" class="form-control" name="edit_nama"
                                        value="{{ old('edit_nama') }}">
                                    @error('name')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Berat</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="edit_berat" name="edit_berat" class="form-control"
                                        value="{{ old('edit_berat') }}">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Gram</span>
                                    </div>
                                    @error('edit_berat')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Stok</label>
                                <div class="form-group mb-3">
                                    <input type="number" name="edit_stok" id="edit_stok" class="form-control" value="{{ old('edit_stok') }}">
                                    @error('edit_stok')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Satuan</label>
                                <div class="input-group mb-3">
                                    <select name="edit_satuan" id="edit_satuan" class="form-control" value="{{ old('edit_satuan') }}">
                                        @foreach ($satuan as $s)
                                            <option value="{{ $s->nama }}">{{ $s->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('edit_satuan')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Harga</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    </div>
                                    <input type="number" id="edit_harga" name="edit_harga"
                                        value="{{ old('edit_harga') }}" class="form-control">
                                    @error('edit_harga')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="edit_kategori" id="edit_kategori" class="form-control">
                                        @foreach ($category as $c)
                                            <option id="edit_kategori" value="{{ $c->id }}">{{ $c->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('edit_kategori')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sub Kategori</label>
                                    <select name="edit_sub_kategori" id="edit_sub_kategori" class="form-control">

                                    </select>
                                    @error('edit_sub_kategori')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sub Sub Kategori</label>
                                    <select name="edit_sub_sub_kategori" id="edit_sub_sub_kategori" class="form-control">

                                    </select>
                                    @error('edit_sub_sub_kategori')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Keterangan singkat</label>
                                    <textarea class="form-control" id="edit_keterangan_singkat"
                                        name="edit_keterangan_singkat" rows="4" cols="8"></textarea>
                                    @error('edit_keterangan_singkat')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea id="editbody" class="form-control edit_keterangan" name="edit_keterangan"
                                        rows="10" cols="50"></textarea>
                                    @error('edit_keterangan')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Image</label>
                                    <span class="text-danger">* max size 2mb</span>
                                    <br><img src="" class="img img-thumbnail" id="image_view" style="max-width:200px">
                                    <br><input type="text" class="form-control input-default" id="image_edit" name="default"
                                        hidden>

                                    <input type="file" class="form-control input-default" name="edit_image">
                                    @error('edit_image')
                                        <br>
                                        <div class="text-danger mt-1">{{ message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var body = document.getElementById("body");
        CKEDITOR.replace(body, {
            language: 'en-gb'
        });
        CKEDITOR.config.allowedContent = true;

    </script>
    <script>
        $(document).ready(function() {
            $("#kategori").change(function() {
                var category = $("#kategori").val();
                $.ajax({
                    type: 'get',
                    method: 'get',
                    url: '/backend/sub-category/' + category,
                    data: '_token = <?php echo csrf_token(); ?>',
                    success: function(hsl) {
                        if (hsl.record > 0) {

                            var data = [];
                            data = hsl.data;
                            $("#sub_category").children().remove().end();
                            $.each(data, function(i, item) {
                                $("#sub_category").append('<option  value="' + item.id +
                                    '">' + item.name + '</option>');
                            })
                            sub_kategori();
                        }
                    }
                });
            })
            $("#edit_kategori").change(function() {
                edit_kategori();
            })
            $("#sub_kategori").change(function() {
                sub_kategori()
            })
            $("#edit_sub_kategori").change(function() {
                edit_sub_kategori()
            })

        });

        function edit(id) {

            var url = "<?php echo env('APP_URL'); ?>/";

            $.ajax({
                type: 'get',
                method: 'get',
                url: '/backend/product/find/' + id,
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(hsl) {
                    if (hsl.error) {
                        alert(hsl.message);
                    } else {
                        $("#image_view").show();
                        $("#image_view").attr('src', url + hsl.image);
                        $("#image_edit").val(hsl.image);
                        $("#edit_id").val(hsl.id);
                        $("#edit_kode_brg").val(hsl.kode_brg);
                        $("#edit_nama").val(hsl.nama);
                        $("#edit_stok").val(hsl.stok);
                        $("#edit_satuan").val(hsl.satuan);
                        $("#edit_berat").val(hsl.berat);
                        $("#edit_harga").val(hsl.harga);
                        $("#edit_kategori").val(hsl.kategori);
                        $("#edit_sub_kategori").val(hsl.sub_kategori);
                        $("#edit_sub_sub_kategory").val(hsl.sub_sub_kategory);
                        edit_kategori();
                        edit_sub_kategori();
                        $("textarea#edit_keterangan_singkat").val(hsl.keterangan_singkat);
                        $("textarea.edit_keterangan").val(hsl.keterangan);
                        $("#editModal").modal();
                        var editbody = document.getElementById("editbody");
                        CKEDITOR.replace(editbody, {
                            language: 'en-gb'
                        });
                        CKEDITOR.config.allowedContent = true;
                    }
                }
            });

        }

        function edit_kategori() {
            var category = $("#edit_kategori").val();
            $.ajax({
                type: 'get',
                method: 'get',
                url: '/backend/sub-category/' + category,
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(hsl) {
                    if (hsl.record > 0) {

                        var data = [];
                        data = hsl.data;
                        $("#edit_sub_kategori").children().remove().end();
                        $.each(data, function(i, item) {
                            $("#edit_sub_kategori").append('<option  value="' + item.id + '">' + item
                                .name + '</option>');
                        })
                        edit_sub_kategori();
                    }
                }
            });
        }

        function sub_kategori() {
            var sc = $("#sub_category").val();
            $.ajax({
                type: 'get',
                method: 'get',
                url: '/backend/sub-sub-category/' + sc,
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(hsl) {
                    if (hsl.record > 0) {
                        var data = [];
                        data = hsl.data;
                        $("#sub_sub_category").children().remove().end();
                        $.each(data, function(i, item) {
                            $("#sub_sub_category").append('<option  value="' + item.id + '">' + item
                                .name + '</option>');
                        })

                    }
                }
            });
        }

        function edit_sub_kategori() {
            var sc = $("#edit_sub_kategori").val();
            $.ajax({
                type: 'get',
                method: 'get',
                url: '/backend/sub-sub-category/' + sc,
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(hsl) {
                    if (hsl.record > 0) {
                        var data = [];
                        data = hsl.data;
                        $("#edit_sub_sub_kategori").children().remove().end();
                        $.each(data, function(i, item) {
                            $("#edit_sub_sub_kategori").append('<option  value="' + item.id + '">' +
                                item.name + '</option>');
                        })

                    }
                }
            });
        }

    </script>
@stop
