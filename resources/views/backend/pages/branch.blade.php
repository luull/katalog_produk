@extends('backend.templates.master')
@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-12 mb-5">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span>Mitrasalur</span></li>
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
                                <th>Kode MS</th>
                                <th>Pengelola</th>
                                <th>Propinsi</th>
                                <th>Kota</th>
                                <th>Kecamatan</th>
                                <th>Kode Pos</th>
                                <th>Status</th>
                                <th>Hits</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $status = ['Cabang', 'Kantor Pusat', 'Cabang'];
                            ?>
                            @foreach ($data as $d)

                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $d->branch_id }}</td>
                                    <td>{{ $d->name }}</td>
                                    <td>{{ $d->propinsi }}</td>
                                    <td>{{ $d->kota->city_name }}</td>
                                    <td>{{ $d->kecamatan->subdistrict_name }}</td>
                                    <td>{{ $d->zip }}</td>
                                    <td>{{ $status[$d->main_office] }}</td>
                                    <td>{{ $d->count }}</td>

                                    <td>{{ $d->created_at }}</td>
                                    <td>{{ $d->updated_at }}</td>
                                    <td>
                                        <a href="#" class="edit" onclick="edit({{ $d->id }})" alt="Edit"><i
                                                data-feather="edit"></i></a>
                                        <a href="/backend/branch/delete/{{ $d->id }}" alt="Delete"><i
                                                data-feather="trash" class="text-danger"></i></a>
                                        <a href="#" class="setpass" onclick="setpass({{ $d->id }})"
                                            alt="Set Password"><i data-feather="key"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- modal set password-->
    <div class="modal fade" id="pwdModal" tabindex="-1" role="dialog" aria-labelledby="pwdModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Set Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="close"></i>
                    </button>
                </div>
                <form action="{{ route('update-branch-password') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" id="new_password" class="form-control" name="new_password">
                                    <input type="hidden" id="pass_id" name="pass_id">

                                    @error('new_password')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
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
    <!-- Modal Add-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Create Mitrasalur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="close"></i>
                    </button>
                </div>
                <form action="{{ route('create-branch') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kode Mitrasalur</label>
                                    <input type="text" id="branch_id" class="form-control" name="branch_id">
                                    @error('branch_id')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Pengelola Mitrasalur</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Propinsi</label>
                                    <select name="province" id="province" class="form-control">
                                        <option value="">Silahkan Pilih</option>
                                        @foreach ($province as $p)
                                            <option value="{{ $p->province_id }}">{{ $p->province }}</option>
                                        @endforeach
                                    </select>

                                    @error('province')
                                        <br>
                                        <div class="text-danger mt-1">This field is required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kota</label>
                                    <select name="city" id="city" class="form-control">

                                    </select>
                                    @error('city')
                                        <br>
                                        <div class="text-danger mt-1">This field is required</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kecamatan</label>
                                    <select name="subdistrict" id="subdistrict" class="form-control">

                                    </select>
                                    @error('subdistrict')
                                        <br>
                                        <div class="text-danger mt-1">This field is required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kode Pos</label>
                                    <input type="text" id="zip" class="form-control" name="zip">
                                    @error('zip')
                                        <br>
                                        <div class="text-danger mt-1">This field is required</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" id="password" class="form-control" name="password">

                                    @error('password')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
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
                    <h5 class="modal-title" id="editModalLabel">Edit Mitrasalur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="close"></i>
                    </button>
                </div>
                <form action="{{ route('update-branch') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="id" id="edit_id" hidden>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kode Mitrasalur</label>
                                    <input type="text" id="edit_branch_id" class="form-control" name="edit_branch_id"
                                        value="{{ old('edit_branch_id') }}">
                                    @error('edit_branch_id')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Pengelola Mitrasalur</label>
                                    <input type="text" class="form-control" id="edit_name" name="edit_name"
                                        value="{{ old('edit_name') }}">
                                    @error('edit_nama')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Propinsi</label>
                                    <select name="edit_province" id="edit_province" class="form-control">
                                        <option value="">Silahkan Pilih</option>
                                        @foreach ($province as $p)
                                            <option value="{{ $p->province_id }}">{{ $p->province }}</option>
                                        @endforeach
                                    </select>

                                    @error('edit_province')
                                        <br>
                                        <div class="text-danger mt-1">This field is required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kota</label>
                                    <select name="edit_city" id="edit_city" class="form-control">

                                    </select>
                                    @error('edit_city')
                                        <br>
                                        <div class="text-danger mt-1">This field is required</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kecamatan</label>
                                    <select name="edit_subdistrict" id="edit_subdistrict" class="form-control">

                                    </select>
                                    @error('edit_subdistrict')
                                        <br>
                                        <div class="text-danger mt-1">This field is required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kode Pos</label>
                                    <input type="text" id="edit_zip" class="form-control" name="edit_zip">
                                    @error('edit_zip')
                                        <br>
                                        <div class="text-danger mt-1">This field is required</div>
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
        $(document).ready(function() {
            $("#province").change(function() {
                var province = $("#province").val();
                city_list(province, 'city', 0)
            })
            $("#edit_province").change(function() {
                var province = $(this).val();
                var city = $("#edit_city").val();
                city_list(province, 'edit_city', city)
            })
            $("#city").change(function() {
                var id = $(this).val();
                subdistrict_list(id, 'subdistrict', 0)
            })
            $("#edit_city").change(function() {
                var id = $(this).val();
                var subdistrict = $("#edit_subdistrict").val();
                subdistrict_list(id, 'edit_subdistrict', subdistrict)
            })


        });


        function city_list(id, element, index) {
            $.ajax({
                type: 'get',
                method: 'get',
                url: '/backend/city/' + id,
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(hsl) {
                    if (hsl.record > 0) {

                        var data = [];
                        data = hsl.data;
                        $("#" + element).children().remove().end();
                        $.each(data, function(i, item) {
                            if (item.city_id == index) {
                                $("#" + element).append('<option  value="' + item.city_id +
                                    '" selected>' +
                                    item.city_name +
                                    '</option>');
                            } else {
                                $("#" + element).append('<option  value="' + item.city_id + '">' +
                                    item.city_name +
                                    '</option>');
                            }

                        })


                    }
                }
            });
        }

        function subdistrict_list(id, element, index) {
            $.ajax({
                type: 'get',
                method: 'get',
                url: '/backend/subdistrict/' + id,
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(hsl) {
                    if (hsl.record > 0) {

                        var data = [];
                        data = hsl.data;
                        $("#" + element).children().remove().end();
                        $.each(data, function(i, item) {
                            if (item.subdistrict_id == index) {
                                $("#" + element).append('<option  value="' + item.subdistrict_id +
                                    '" selected>' +
                                    item.subdistrict_name +
                                    '</option>');
                            } else {
                                $("#" + element).append('<option  value="' + item.subdistrict_id +
                                    '">' +
                                    item.subdistrict_name +
                                    '</option>');
                            }

                        })

                    }
                }
            });
        }

        function edit(id) {

            var url = "<?php echo env('APP_URL'); ?>/";
            $.ajax({
                type: 'get',
                method: 'get',
                url: '/backend/branch/find/' + id,
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(hsl) {
                    if (hsl.error) {
                        alert(hsl.message);
                    } else {
                        $("#edit_id").val(hsl.id);
                        $("#edit_branch_id").val(hsl.branch_id);
                        $("#edit_name").val(hsl.name);
                        $("#edit_province").val(hsl.province);
                        $("#edit_city").val(hsl.city);
                        $("#edit_subdistrict").val(hsl.subdistrict);
                        $("#edit_zip").val(hsl.zip);
                        city_list(hsl.province, 'edit_city', hsl.city);
                        subdistrict_list(hsl.city, 'edit_subdistrict', hsl.subdistrict)


                        $("#editModal").modal();

                    }
                }
            });
        }

        function setpass(id) {
            $("#pass_id").val(id);
            $("#pwdModal").modal();
        }

    </script>
@stop
