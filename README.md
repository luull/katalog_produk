composer require realrashid/sweet-alert - newpackage

in config/app.php :
RealRashid\SweetAlert\SweetAlertServiceProvider::class,
'Alert' => RealRashid\SweetAlert\Facades\Alert::class,

php artisan sweetalert:publish

https://sweetalert2.github.io/#usage - jquery cdn
