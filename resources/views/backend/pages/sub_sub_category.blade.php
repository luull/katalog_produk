@extends('backend.templates.master')
@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-12 mb-5">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Sub Sub Kategori</span></li>
            </ol>
        </nav>
    </div>
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        @if (session('message'))
        <div class="alert {{ session('color') }} alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button> {{ session('message') }}</div>
        @endif
        <div class="widget-content widget-content-area py-4 px-4 br-6">
            <div class="container">
                <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#addModal">Create</button>
                <table id="dt-table" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Sub Kategori</th>
                            <th>Sub Sub Kategori</th>
                            <th>Date created</th>
                            <th>Created by</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 ?>
                        @foreach ($data as $d )

                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$d->category->name}}</td>
                            <td>{{$d->sub_category->name}}</td>
                            <td>{{$d->name}}</td>
                            <td>{{$d->date_created}}</td>
                            <td>{{$d->created_by}}</td>
                            <td>
                                <a href="#" onclick="edit({{$d->id}})" alt="Edit"><i data-feather="edit"></i></a>
                                <a href="/backend/subsubcategory/delete/{{$d->id}}" alt="Delete"><i data-feather="trash" class="text-danger"></i></a>
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
                <h5 class="modal-title" id="addModalLabel">Create Sub Sub category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="close"></i>
                </button>
            </div>
            <form action="{{ route('create-subsubcategory') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="id_category" class="form-control" id="id_category">
                                    <option value="">Silahkan Pilih</option>
                                    @foreach ($category as $c )
                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Sub Kategori</label>
                                <select name="id_sub_category" class="form-control" id="id_sub_category">
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Sub Kategori</label>
                                <input type="text" id="name" class="form-control" name="name">
                                @error('name')
                                <br>
                                <div class="text-danger mt-1">{{message}}</div>
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
                <h5 class="modal-title" id="editModalLabel">Edit sub category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="close"></i>
                </button>
            </div>
            <form action="{{ route('update-subsubcategory') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" name="id" id="edit_id" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="edit_id_category" class="form-control" id="edit_id_category">
                                    <option value="">Silahkan Pilih</option>
                                    @foreach ($category as $c )
                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Sub Kategori</label>
                                <select name="edit_id_sub_category" class="form-control" id="edit_id_sub_category">
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Sub Kategori</label>
                                <input type="text" id="edit_name" class="form-control" name="edit_name">
                                @error('edit_name')
                                <br>
                                <div class="text-danger mt-1">{{message}}</div>
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
    $(document).ready(function(){
        $("#id_category").change(function(){
                var id=$(this).val();
                 $.ajax({
            type: 'get',
            method: 'get',
            url: '/backend/sub-category/' + id,
            data: '_token = <?php echo csrf_token() ?>',
            success: function(hsl) {
                if (hsl.record>0) {
                    var data = [];
                        data = hsl.data;
                        $("#id_sub_category").children().remove().end();
                        $.each(data, function(i, item) {
                            $("#id_sub_category").append('<option  value="' + item.id + '">' + item.name + '</option>');
                        })
                  
                }
            }
        });
        })
    })
    function edit(id) {
        $.ajax({
            type: 'get',
            method: 'get',
            url:  '/backend/subsubcategory/find/' + id,
            data: '_token = <?php echo csrf_token() ?>',
            success: function(hsl) {
                if (hsl) {
                    $("#edit_id").val(hsl.id);
                    $("#edit_id_category").val(hsl.id_category);
                    edit_id_sub_category(hsl.id_category)
                    $("#edit_name").val(hsl.name);
                    
                    $("#editModal").modal();

                }
            }
        });
    }
    function edit_id_sub_category(id){
            $.ajax({
            type: 'get',
            method: 'get',
            url: '/backend/sub-category/' + id,
            data: '_token = <?php echo csrf_token() ?>',
            success: function(hsl) {
                if (hsl.record>0) {
                    var data = [];
                        data = hsl.data;
                        $("#edit_id_sub_category").children().remove().end();
                        $.each(data, function(i, item) {
                            $("#edit_id_sub_category").append('<option  value="' + item.id + '">' + item.name + '</option>');
                        })
                
                }
            }
        });
    }
     
</script>
@stop