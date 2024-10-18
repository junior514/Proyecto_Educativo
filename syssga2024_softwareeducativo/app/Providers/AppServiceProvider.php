<?php

namespace App\Providers;

use App\Models\Ajuste;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

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
        //
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);
        view()->composer('*', function ()
        {
        //    if (isset(Auth::user()->id)){
               $empresa = Ajuste::first();
               $estudiantes_general = DB::table('estudiantes')->orderBy('nomEst')->get();
               View::share(['empresa_ini'=> $empresa, "estudiantes_general" => $estudiantes_general]);
        //    }
       });
    }
}
