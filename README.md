composer require realrashid/sweet-alert - newpackage

in config/app.php :
RealRashid\SweetAlert\SweetAlertServiceProvider::class,
'Alert' => RealRashid\SweetAlert\Facades\Alert::class,

php artisan sweetalert:publish

https://sweetalert2.github.io/#usage - jquery cdn

composer require milon/barcode - new package barcode

in config/app.php :
Milon\Barcode\BarcodeServiceProvider::class,
'DNS1D' => Milon\Barcode\Facades\DNS1DFacade::class,
'DNS2D' => Milon\Barcode\Facades\DNS2DFacade::class,

php artisan config:publish milon/barcode

https://github.com/milon/barcode - documentation
