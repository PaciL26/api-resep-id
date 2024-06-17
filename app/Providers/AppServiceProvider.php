<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('gambar', function ($attribute, $value, $parameters, $validator) {
            // Logika validasi kustom Anda di sini
            // Misalnya, cek apakah file tersebut adalah gambar
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $mimeType = $value->getMimeType();

            return in_array($mimeType, $allowedMimeTypes);
        });
    }
}
