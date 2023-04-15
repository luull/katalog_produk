@extends('backend.templates.master')
@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-12 mb-5">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Kategori</span></li>
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
                                <th>Icon</th>
                                <th>Nama</th>
                                <th>Header Background</th>
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
                                <td><i class="fa fa-{{ $d->icon }}" style="font-size: 30px"></i></td>
                                <td>{{$d->name}}</td>
                                <td><img class="mb-3" src="{{ asset($d->bg_header) }}" style="height:100px;border-radius:8px" alt=""></td>
                                <td>{{$d->date_created}}</td>
                                <td>{{$d->created_by}}</td>
                                <td>
                                    <a href="#" class="edit" onclick="edit({{$d->id}})" id="e-{{$d->id}}" alt="Edit"><i data-feather="edit"></i></a>
                                    <a href="/backend/category/delete/{{$d->id}}" alt="Delete"><i data-feather="trash" class="text-danger"></i></a>
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
                <h5 class="modal-title" id="addModalLabel">Create category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i data-feather="close"></i>
                </button>
            </div>
            <form action="{{ route('create-category') }}" method="POST" enctype="multipart/form-data">
              @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Kategori</label>
                                <input type="text" class="form-control" name="name">
                                @error('name')
                                <br>
                                <div class="text-danger mt-1">This field is required</div>
                                @enderror
                            </div>
                        </div>
                       <div class="col-md-12">
                            <label for="basic-url" class="form-label">Icon</label>
                            <div class="input-group">
                              <span class="input-group-text" id="basic-addon3">fa fa-</span>
                              <input type="text" name="icon" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4">
                            </div>
                            <div class="form-text" id="basic-addon4">Referensi icon <a href="https://fontawesome.com/v4/icons/" target="_blank">https://fontawesome.com/v4/icons/</a></div>
                       
                       </div>
                          
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Header Background</label>
                                <input type="file" class="form-control" name="bg_header">
                                @error('bg_header')
                                <br>
                                <div class="text-danger mt-1">This file is not support</div>
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
                <h5 class="modal-title" id="editModalLabel">Edit category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i data-feather="close"></i>
                </button>
            </div>
            <form action="{{ route('update-category') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="text" name="id" id="edit_id" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Kategori</label>
                                <input type="text" id="edit_name" class="form-control" name="name">
                                @error('name')
                                <br>
                                <div class="text-danger mt-1">This field is required</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                 
                                <label for="basic-url" class="form-label">Icon</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">fa fa-</span>
                                  <input type="text" name="icon" id="edit_icon" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4">
                                </div>
                                <div class="form-text" id="basic-addon4">Referensi icon <a href="https://fontawesome.com/v4/icons/" target="_blank">https://fontawesome.com/v4/icons/</a></div>
                            
                        </div>
                        <div class="col-md-4 col-12">
                            <label class="my-3" for="">Header Background </label>
                            <br>
                            <div id="edit_bg_header"></div>
                        </div>
                        <div class="col-md-8 col-12">
                            <label class="my-3" for="">Ubah Background</label>
                            <small class="text-danger">* batas ukuran 2mb</small>
                            <br>
                            <input type="file" class="form-control" name="bg_header">
                            <input type="text" class="form-control" id="edit_default" name="default" hidden>
                            @error('bg_header')
                            <br>
                            <div class="text-danger mt-1">Gambar tidak sesuai dengan ketentuan</div>
                            @enderror
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
<script >
  

     function edit(id){
            
           var url="<?PHP echo env('APP_URL');?>";

            $.ajax({
                type:'get',
                method:'get',
                url:'/backend/category/find/'  + id ,
                data:'_token = <?php echo csrf_token() ?>'   ,
                success:function(hsl) {
                   if (hsl.error){
                       alert(hsl.message);
                   } else{
                    $("#edit_id").val(hsl.id);
                    $("#edit_name").val(hsl.name);
                    $("#edit_icon").val(hsl.icon);
                    $("#edit_default").val(hsl.bg_header);
                    // var bla = $("#edit_bg_header").html('<img src="asset'( + hsl.bg_header + )'" style="height:100px" />');
                    $("#edit_bg_header").html($("<img>").attr("src", hsl.bg_header));
                    $("#editModal").modal();
                    console.log(bla);

                   }
                }
            });
        }
</script>
@stop
