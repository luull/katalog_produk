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
                    <li class="breadcrumb-item active" aria-current="page"><span>Pages</span></li>
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

                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($data as $d)

                                <tr>
                                    <td><img src="{{ asset($d->image) }}" style="max-height: 70px;"
                                            alt="{{ asset($d->image) }}"></td>
                                    <td>Title : {{ $d->title }}<br>
                                        Slug : {{ $d->slug }}<br><br>
                                        Content : <br>{!! $d->content !!}<br>
                                        <br>Created At :{{ $d->created_at }}<br>
                                        @if (!empty($d->update_at))
                                            Updated At : {{ $d->updated_at }}
                                        @endif
                                        <br>

                                        <a href="#" class="edit" onclick="edit({{ $d->id }})"
                                            id="e-{{ $d->id }}" alt="Edit"><i data-feather="edit"></i></a>
                                        <a href="/backend/pages/delete/{{ $d->id }}" alt="Delete"><i
                                                data-feather="trash" class="text-danger"></i></a>
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
                    <h5 class="modal-title" id="addModalLabel">Create Pages</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="close"></i>
                    </button>
                </div>
                <form action="{{ route('create-pages') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title </label>
                                    <input type="text" class="form-control" value="{{ old('title') }}" name="title">
                                    @error('title')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Content</label>
                                    <textarea id="body" class="form-control" name="content" rows="10"
                                        cols="50">{{ old('content') }}</textarea>
                                    @error('contentn')
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
                    <h5 class="modal-title" id="editModalLabel">Edit Pages</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="close"></i>
                    </button>
                </div>
                <form action="{{ route('update-pages') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="id" id="edit_id" hidden>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title </label>
                                    <input type="text" class="form-control" value="{{ old('edit_title') }}"
                                        name="edit_title" id="edit_title">
                                    @error('edit_title')
                                        <br>
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Contentn</label>
                                    <textarea id="editbody" class="form-control edit_content" name="edit_content" rows="10"
                                        cols="50"></textarea>
                                    @error('edit_content')
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
        function edit(id) {

            var url = "<?php echo env('APP_URL'); ?>/";

            $.ajax({
                type: 'get',
                method: 'get',
                url: '/backend/pages/find/' + id,
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(hsl) {
                    if (hsl.error) {
                        alert(hsl.message);
                    } else {
                        $("#image_view").show();
                        $("#image_view").attr('src', url + hsl.image);
                        $("#image_edit").val(hsl.image);
                        $("#edit_id").val(hsl.id);
                        $("#edit_title").val(hsl.title);
                        $("textarea.edit_content").val(hsl.content);
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

    </script>
@stop
