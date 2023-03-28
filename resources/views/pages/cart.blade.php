@extends('templates.master')
@section('content')

    <div class="container-fluid mt-5">
        <div class="row ">
            <div class="col-md-12">
                <div class="breadcrumb-five">
                    <ul class="breadcrumb">
                        <li class="mb-2"><a href="/">Beranda</a>
                        </li>
                        <li class="active mb-2"><a href="javscript:void(0);">Keranjang</a></li>

                    </ul>
                </div>
            </div>

            @if (count($data) > 0)
            <div class="container">
                <div class="row">
                    
                    <div class="col-lg-8 col-md-8 mt-1">
                        <h4 class="nunito bolder m-3">Keranjang</h4>
                        @if (session('message'))
                            <div class="alert alert-{{ session('alert') }} alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span>
                                </button> {{ session('message') }}
                            </div>
                        @endif
                        @foreach ($data as $d)
                            @if ($d->id_user == session('user-session')->id)
                                <div class="card card-cart mb-3 ">


                                    <div class="card-body">
                                        <div class="row pl-1">
                                            <div class="col-1">
                                                @if ($d->status == 0)
                                                    <form id="myForm" action="{{ route('add-dummy') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" value="{{ $d->product->id }}"
                                                            name="id_barang">
                                                        <input type="hidden" value="{{ $d->product->berat }}"
                                                            name="berat">
                                                        <button type="submit" class="btn-uncheckbox mt-1"></button>
                                                    </form>
                                                    {{-- <label class="containers mt-3"> &nbsp;
                                                <input type="checkbox" value="{{$d->pid}}" name="values"/>
                                                <span class="checkmark"></span>
                                            </label> --}}
                                                @else
                                                    <form action="{{ route('delete-dummy') }}" class="mt-1" method="post">
                                                        @csrf
                                                        <input type="hidden" value="{{ $d->id }}" name="id_cart">
                                                        <button type="submit" class="btn-checkbox"><i
                                                                class="fa fa-check"></i></button>
                                                    </form>
                                                    {{-- <label class="containers mt-3"> &nbsp;
                                                <input type="checkbox" id="myCheck" value="{{$d->id_barang}}" onclick="myFunction()" checked />
                                                <span class="checkmark"></span>
                                            </label> --}}
                                                @endif
                                            </div>
                                            <div class="col-md-1 col-sm-3 col-xs-3 col-4 align-self-start">
                                                <img alt="avatar" src="{{ asset($d->product->image) }}" class="img-fluid ml-3 mb-3">
                                            </div>
                                            <div class="col-md-8 col-sm-8 col-xs-8 col-12 align-self-start mb-5">
                                                <input type="hidden" id="berat" value="{{ $d->berat }}">
                                                <h4 class="size-16">{{ $d->product->nama }}</h4>
                                                <h5 class="semi-bolder size-14 mb-0">
                                                    Rp.{{ number_format($d->product->harga) }} | Jumlah
                                                    ({{ $d->qty }})</h5>



                                            </div>
                                            <div class="col-md-2 float-right col-sm-12 col-xs-12 col-12 align-self-center mb-0">
                                                <a href="/deletecart/{{ $d->id }}" title="Hapus barang"> <i
                                                        data-feather="trash"></i></a>
                                                <a href="#" class="ml-2" onclick="javascript:edit({{ $d->id }})"
                                                    title="Ubah Jumlah"><i data-feather="edit"></i></a>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endif
                        @endforeach

                    </div>
                    <div class="col-md-4">
                        <form id="myForm" action="{{ route('add-dummy') }}" method="post">
                            @csrf
                            <input type="hidden" id="getID" name="id_barang">
                            <input type="hidden" id="beratnya" name="berat">
                        </form>
                        <div class="card card-cart2">
                            <div class="card-body">
                                <h4 class="nunito bolder">Ringkasan Belanja</h4>
                                <p class="nunito size-16">Total Harga ({{ $countbuy }} Barang)
                                    <span style="float: right;">Rp. {{ number_format($sum) }}</span>
                                </p>
                                <p class="nunito size-16">Total Diskon Barang
                                    <span style="float: right;">Rp. {{ number_format($diskon) }}</span>
                                </p>
                                <hr>
                                <h4 class="nunito bolder">Total Harga <span style="float: right;">Rp.
                                        {{ number_format($sum) }}</span></h4>
                               
                            </div>
                            <div class="card-footer">
                                <div class="row justify-content-between">
                                    <div class="col-md-6 mb-2">

                                        <a href="/" class="btn btn-default btn-block mb-0">Belanja Lagi</a> 
                                    </div>
                                    <div class="col-md-6 mb-2">

                                        <a
                                            href="/checkout"
                                            class="btn btn-success btn-block mb-0 {{ $sum == '0' ? 'btn-default disabled' : 'btn-success' }}">
                                            Beli</a>
                                    </div>

                                </div>
                              
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            @else

                <div class="row w-100 justify-content-center">
                    <div class="alert alert-success text-center p-3 m-3">Keranjang Masih Kosong</div>
                </div>
            @endif


        </div>
    </div>
    <!-- Modal Add-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Ubah jumlah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="close"></i>
                    </button>
                </div>
                <form action="{{ route('update-qty') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body custom-qty">
                        <input type="hidden" name="id" id="edit_id">
                        <input type="text" name="qty" id="edit_qty">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Ubah</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script>
        function edit(id) {
            var url = "<?php echo env('APP_URL'); ?>/";

            $.ajax({
                type: 'get',
                method: 'get',
                url: '/getqty/find/' + id,
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(hsl) {
                    if (hsl.error) {
                        alert(hsl.message);
                    } else {
                        $("#edit_id").val(hsl.id);
                        $("#edit_qty").val(hsl.qty);
                        jQuery.noConflict();
                        $("#addModal").modal('show');
                    }
                }
            });
        }

    </script>
    {{-- <script>
function myFunction() {
  var checkBox = document.getElementById("myCheck");
  var get = document.getElementById("myCheck").value;
  if (checkBox.checked == true){
    console.log(get);
    document.getElementById("getID2").value = get;
    // document.getElementById("myForm2").submit();
  } else {
    document.getElementById("getID2").value = get;
    // document.getElementById("myForm2").submit();
  }
}
</script> --}}

@endsection
