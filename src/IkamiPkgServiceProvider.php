<?php 

namespace IkamiPkg;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class IkamiPkgServiceProvider extends ServiceProvider
{
	public function register()
	{
		// 
	}

	public function boot()
	{
		Route::group($this->backpackRoute(), function () {
            $this->loadRoutesFrom(__DIR__.'/routes/backpack.php');
        });

        $this->publishes([
            __DIR__.'/.env.example' => base_path('.env.example'),
        ], 'ikami-env');

		$timestamps = date('Y_m_d_His', strtotime('1986-01-17'));

		$this->publishes([
            __DIR__.'/public/uploads/logo.jpg' => public_path('uploads/logo.jpg'),
            __DIR__.'/config/adminlte.php' => config_path('adminlte.php'),
            __DIR__.'/views/auth/auth-page.blade.php' => resource_path('views/vendor/adminlte/auth/auth-page.blade.php'),
            __DIR__.'/views/master.blade.php' => resource_path('views/vendor/adminlte/master.blade.php'),
            __DIR__.'/js/bootstrap.js' => resource_path('js/bootstrap.js'),
            __DIR__.'/sass/app.scss' => resource_path('sass/app.scss'),
            __DIR__.'/webpack.mix.js' => base_path('webpack.mix.js'),
            __DIR__ . '/database/migrations/create_admins_table.php' => database_path('migrations/'.$timestamps.'_create_admins_table.php'),
            __DIR__.'/config/backpack/base.php' => config_path('backpack/base.php'),
            __DIR__.'/views/sidebar_content.blade.php' => resource_path('views/vendor/backpack/base/inc/sidebar_content.blade.php'),
            __DIR__.'/app/User.php' => base_path('app/User.php'),
            __DIR__.'/routes/web.php' => base_path('routes/web.php'),
        ], 'ikami-starter');
	}

	private function backpackRoute()
    {
        return [
            'prefix'     => config('backpack.base.route_prefix'),
            'middleware' => ['web', backpack_middleware()],
            'namespace'  => 'IkamiPkg\Controllers'
        ];
    }
}