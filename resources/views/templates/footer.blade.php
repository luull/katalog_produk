<footer class="footer">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-7">
                        @if(session('company')!=null)
                        <img src="{{ asset('images/logo.png') }}" style="height:50px" alt="">
                        <hr>
                        <h4 class="nunito bolder text-left">{{session('company')->nama}}</h4>
                        <p class="text-left">{{session('company')->tentang_web}}</p>

                        @endif
                    </div>
                    
                    <div class="col-md-5 mt-3">
                        <h4 class="nunito bolder text-left">Bantuan dan Paduan</h4>
                        <ul>
                            <li class="text-left"><a href="/faq" >Faq</a> </li>
                            <li class="text-left"><a href="/panduan" >Panduan</a> </li>
                            <li class="text-left"><a href="/conntact-us" >Hubungi Kami</a> </li>
                        </ul>
                    </div>
                </div>
            </div>
            @if (Session::has('data_refferal'))
            <div class="col-md-5 bg">
                <div class="row justify-content-center">
                    <div class="col-md-3 col-4">
                @php 
                  if (isset(session('data_refferal')->foto)){
                    echo '<img style="height:100px" src="'.env('WEB_PROFIL_MEMBER').'/'.session('data_refferal')->foto.'" class="img-thumbnail" style="height:180px;" alt="">';

                }

                @endphp
                </div>  
                <div class="col-md-6 col-8">
                    <div class="mb-1 text-left">Di Refferensikan Oleh :</div>
                    <div class="mb-1 text-left bolder"> 
                    @if  (session('data_refferal')->nama)
                       {{session('data_refferal')->nama}}
                    @endif
                    </div>
                    @IF (session('data_refferal')->wa)
                    <div class="mb-0 text-left"> <a class="nunito semi-bolder" href="https://api.whatsapp.com/send?phone={{session('data_refferal')->wa}}"><i class="fa fa-whatsapp mr-2"></i> {{session('data_refferal')->wa}}</a></div>
                    @endif
                    @IF (session('data_refferal')->ig)
                    <div class="mb-0 text-left"> <a class="nunito semi-bolder" href="https://www.instagram.com/{{session('data_refferal')->ig}}/"><i class="fa fa-instagram mr-2"></i> {{session('data_refferal')->ig}}</a></div>
                    @endif
                    @IF (session('data_refferal')->fb)
                    <div class="mb-0 text-left"> <a class="nunito semi-bolder" href="https://www.facebook.com/{{session('data_refferal')->fb}}"><i class="fa fa-facebook mr-2"></i>{{session('data_refferal')->fb}}</a></div>
                    @endif
                </div>
            </div>
            </div>
            @endif
        </div>
    </div>
</footer>
