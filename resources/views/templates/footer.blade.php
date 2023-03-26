<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6 mt-3">
                        @if(session('company')!=null)
                        <h4 class="nunito bolder">{{session('company')->nama}}</h4>
                        <p>{{session('company')->tentang_web}}</p>

                        @endif
                    </div>
                    
                    <div class="col-md-6 mt-3">
                        <h4 class="nunito bolder">Bantuan dan Paduan</h4>
                        <ul>
                            <li><a href="/faq" >Faq</a> </li>
                            <li><a href="/panduan" >Panduan</a> </li>
                            <li><a href="/conntact-us" >Hubungi Kami</a> </li>
                        </ul>
                    </div>
                </div>
            </div>
            @if (Session::has('data_refferal'))
            <div class="col-md-6 align-self-start bg">
                <div class="row">
                    <div class="col-md-4">
                @php 
                  if (isset(session('data_refferal')->foto)){
                    echo '<img src="'.env('WEB_PROFIL_MEMBER').'/'.session('data_refferal')->foto.'" class="img-thumbnail" style="height:180px;" alt="">';

                }

                @endphp
                </div>
                <div class="col-md-8">
                    <div class="mb-1">Di Refferensikan Oleh :</div>
                    <div class="mb-1 bolder"> 
                    @if  (session('data_refferal')->nama)
                       {{session('data_refferal')->nama}}
                    @endif
                    </div>
                    @IF (session('data_refferal')->wa)
                    <div class="mb-0"> <a href="https://api.whatsapp.com/send?phone={{session('data_refferal')->wa}}"><img src="{{asset('images/wa.png')}}" style="height:40px">{{session('data_refferal')->wa}}</a></div>
                    @endif
                    @IF (session('data_refferal')->ig)
                    <div class="mb-0"> <a href="https://www.instagram.com/{{session('data_refferal')->ig}}/"><img src="{{asset('images/ig.png')}}" style="height:40px">{{session('data_refferal')->ig}}</a></div>
                    @endif
                    @IF (session('data_refferal')->fb)
                    <div class="mb-0"> <a href="https://www.facebook.com/{{session('data_refferal')->fb}}"><img src="{{asset('images/fb.png')}}" style="height:40px">{{session('data_refferal')->fb}}</a></div>
                    @endif
                </div>
            </div>
            </div>
            @endif
        </div>
    </div>
</footer>
