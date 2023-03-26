@extends('backend.templates.master')
@section('style')
 <link rel="stylesheet" href="{{ asset('templates/admin/assets/bundles/datatables/datatables.min.css')}}">
<link rel="stylesheet" href="{{ asset('templates/admin/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
       
@endsection
@section('content')

<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-12 mb-5">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Admin Manager</span></li>
            </ol>
        </nav>
    </div>
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area py-4 px-4 br-6">
           <div class="container">
                 <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#addModal" id="inputData">Create</button>
              
       
                      @if (session('akses')<=2)
                      
                        @if (session('message'))
                        <div class="alert alert-{{session('alert')}} text-center">{{session('message')}}</div>
                        @endif  
                       <DIV class="table-responsive">
                          <table id="dt-table" class="table dt-table-hover" style="width:100%">
                               <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Nama Admin</th>
                                        <th>Akses</th>
                                        <th>No Handphone</th>
                                        <th>Email</th>
                                        <th>Foto</th>
                                        <th width="150">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admin as $dt)
                                    <tr>
                                        <td>{{ $dt->username }}</td>
                                        <td>{{ $dt->nama }}</td>
                                        <td>{{ $dt->level_admin->nama }}</td>
                                        <td>{{ $dt->telp }}</td>
                                        <td>{{ $dt->email }}</td>
                                        <td><img src="{{ asset($dt->foto) }}" class="img" id="img-{{$dt->id}}" width="70"></td>
                                        <td > 
                                                         <a href="#" class="edit" id="e-{{$dt->id}}" onclick="edit({{$dt->id}})" alt="Edit"><i data-feather="edit" alt="edit"></i></a>
                                            <a href="/backend/admin/delete/{{$dt->id}}"  id="e-{{$dt->id}}" alt="Delete"><i data-feather="trash" class="text-danger"></i></a> 
                               
                                        <a href="#"  class="cng_pwd" id="p-{{$dt->id}}" alt="Change Password"><i data-feather="lock" class="text-warning"></i></a> 
                                    </td>
                                    </tr>
                                        
                                    @endforeach
                                  
                                </tbody>
                                
                            </table>
                            
                        </div>
                    @else 
                    <div class="alert alert-danger text-center">Maaf Anda tidak berhak mengakses menu ini </div>
                    @endif
                    </div>
        </div>
        </div>
    </div>
</div>
        <div class="modal fade" tabindex="-1" role="dialog" id="inputmodal">
            <div class="modal-dialog " role="document">
              <div class="modal-content">
                <form  action="{{route('save_admin_backend')}}" method="Post" enctype="multipart/form-data">    
                    @csrf
                <div class="modal-header">
                  <h5 class="modal-title">Input User Admin</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                        <div class="container-fluid  m-0 p-0">
                                    <div class="card ">
                                        <div class="card-body  p-3">
                                            <div class="basic-form">
                                                 <div class="row">
                           
                                                 <div class="col-12 ">
                                                    <div class="form-group">
                                                        <label>Username</label>
                                                        <input type="text" class="form-control input-default @error('uid')is-invalid @enderror" name="uid" id="uid" placeholder="Username">
                                                        @error('uid')
                                                        <div class="text-danger mt-1 font-italic">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Password</label>
                                                        <input type="text" class="form-control input-default @error('pwd')is-invalid @enderror" name="pwd" id="pwd" placeholder="Password">
                                                        @error('pwd')
                                                        <div class="text-danger mt-1 font-italic">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Nama Admin</label>
                                                        <input type="text" class="form-control input-default @error('nama')is-invalid @enderror" name="nama" id="nama" placeholder="Nama Admin">
                                                        @error('nama')
                                                        <div class="text-danger mt-1 font-italic">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                               
                                                <div class="form-group">
                                                        <label>No Telp</label>
                                                        <input type="text" class="form-control input-default @error('telp')is-invalid @enderror" name="telp" id="telp" placeholder="No Telp">
                                                        @error('telp')
                                                        <div class="text-danger mt-1 font-italic">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="text" class="form-control input-default @error('email')is-invalid @enderror" name="email" id="email" placeholder="Alamat Email">
                                                        @error('email')
                                                        <div class="text-danger mt-1 font-italic">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Hak Akses</label>
                                                        
                                                        <select class="form-control input-default @error('akses')is-invalid @enderror" name="akses" >
                                                        @foreach ($level_admin as $la)
                                                            <option value="{{$la->kode}}">{{$la->nama}}</option>
                                                        @endforeach
                                                    </select>
                                                      
                                                    </div> 
                                                </div>   
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                </div>
                <div class="modal-footer">
                  <input type="submit" id="btnOk" class="btn btn-primary" value="Proses">
                  <button type="button" id="btnClose" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
              </div>
            </div>
          </div>
        
          <div class="modal" tabindex="-1" role="dialog" id="editmodal">
            <div class="modal-dialog " role="document">
              <div class="modal-content">
                <form  action="{{route('update_admin_backend')}}" method="Post" enctype="multipart/form-data">    
                    @csrf
                <div class="modal-header">
                  <h5 class="modal-title">Edit Data</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
        
                   
                        <div class="container-fluid m-0 p-0">
                            <div class="row">
                                <div class="col-12 ">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="basic-form">
                                                
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control input-default @error('edit_uid')is-invalid @enderror" name="edit_uid" id="edit_uid" >
                                                    <input type="hidden" id="edit_id" name="id">
                                                    @error('edit_uid')
                                                    <div class="text-danger mt-1 font-italic">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama Admin</label>
                                                    <input type="text" class="form-control input-default @error('edit_nama')is-invalid @enderror" name="edit_nama" id="edit_nama" >
                                                    @error('edit_nama')
                                                    <div class="text-danger mt-1 font-italic">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>No telp</label>
                                                    <input type="text" class="form-control input-default @error('edit_telp')is-invalid @enderror" name="edit_telp" id="edit_telp" >
                                                    @error('telp')
                                                    <div class="text-danger mt-1 font-italic">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control input-default @error('edit_email')is-invalid @enderror" name="edit_email" id="edit_email" >
                                                    @error('email')
                                                    <div class="text-danger mt-1 font-italic">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                 <div class="form-group">
                                                        <label>Hak Akses</label>
                                                        
                                                        <select class="form-control input-default @error('edit_akses')is-invalid @enderror" name="edit_akses"  id="edit_akses">
                                                        
                                                    </select>
                                                      
                                                    </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                  
                </div>
                <div class="modal-footer">
                  <input type="submit" id="btnOk" class="btn btn-primary" value="Proses">
                  <button type="button" id="btnClose" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
              </div>
            </div>
          </div>

<div class="modal" tabindex="-1" role="dialog" id="ubahpasswordmodal">
            <div class="modal-dialog " role="document">
              <div class="modal-content p-0">
                <div class="modal-header">
                  <h5 class="modal-title">Ubah Password Admin</h5>
                  <hr>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                       <form  action="/backend/change_password/update" method="Post" >    
                                 @csrf
               
                    <div class="row justify-content-center">
                        <div class="col-12">
                            
                                 
                                <div class="basic-form">
                                    <div class="form-group">
                                        <label>Password Baru</label>
                                    <input type="hidden" id="user_id" name="user_id">
                                        <div class="input-group">
                                            <input type="password" class="form-control input-default @error('new_password')is-invalid @enderror" name="new_password" id="new_password" >
                                            <div class="input-group-append" >
                                            <span class="input-group-text" id="n_pwd"><i data-feather="eye" class="text-dark"></i></span>
                                            </div>
                                            @error('new_password')
                                            <div class="row text-danger mt-1 font-italic">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="form-group">
                                    <label>Konfirmasi Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control input-default @error('password1')is-invalid @enderror" name="confirm_password" id="confirm_password" >
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="k_pwd"><i data-feather="eye" class="text-dark"></i></span>
                                            </div>
                                        @error('confirm_password')
                                        <div class="row text-danger mt-1 font-italic">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                        </div>
                    
                    </div>
                    </div>
                     <div class="row justify-content-center ">
                    <input type="submit" class="btn btn-sm btn-info" Value="Update Password">
                    </div>
                     </form>
                </div>
               
            </div>
        </div>
   
                 
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->
@stop


@section('script')
   <script src="{{ asset('templates/admin/plugins/tables/js/datatable/dataTables.bootstrap4.min.js') }}"></script>   <script src="{{ asset('templates/admin/assets/bundles/datatables/datatables.min.js')}}"></script>
  <script src="{{ asset('templates/admin/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>

  <!-- Page Specific JS File -->
  <script src="{{ asset('templates/admin/assets/js/page/datatables.js')}}"></script>
   
    <script >
        $(document).ready(function(){
            $("#mytable").DataTable();
            
         $("#inputData").click(function(){
            $("#inputmodal").modal();
         })
         $(".cng_pwd").click(function(){
            var idnya=$(this).attr('id').split('-');
            var id=idnya[1];
             $("#user_id").val(id);
             $("#ubahpasswordmodal").modal();
         })
       
         $("#n_pwd").click(function(){
        var tipe=$("#new_password").attr('type');
        if (tipe=="password"){
            $("#new_password").prop('type','text');

        }else{
            $("#new_password").prop('type','password');
        }
    })
    $("#k_pwd").click(function(){
        var tipe=$("#confirm_password").attr('type');
        if (tipe=="password"){
            $("#confirm_password").prop('type','text');

        }else{
            $("#confirm_password").prop('type','password');
        }
    })
        })

         function edit(id){
            $.ajax({
                type:'get',
                method:'get',
                url:'/backend/admin/find/'  + id ,
                data:'_token = <?php echo csrf_token() ?>'   ,
                success:function(hsl) {
                   if (hsl.error){
                       alert(hsl.message);

                   } else{
                        $("#edit_id").val(id);
                        
                       $("#edit_uid").val(hsl.hasil.username);
                       $("#edit_nama").val(hsl.hasil.nama);
                       $("#edit_telp").val(hsl.hasil.telp);
                       $("#edit_email").val(hsl.hasil.email);
                        var dt=hsl.data_level;
                        $("#edit_akses").children().remove().end();
                       $.each(dt, function(i, item) {
                           if (item.kode==hsl.hasil.akses){
                                $("#edit_akses").append('<option value="' + item.kode + '" selected>' + item.nama + '</option>' ); 

                           }else{
                                $("#edit_akses").append('<option value="' + item.kode + '">' + item.nama + '</option>' ); 

                           }
                       })

                     
                       $("#editmodal").modal();
                   }
                }
            });
            
        }
    </script>    
@stop

@section('style')
<link href="{{ asset('templates/admin/plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    
@endsection