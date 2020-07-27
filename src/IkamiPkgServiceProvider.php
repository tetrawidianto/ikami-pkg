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
            __DIR__ . '/database/migrations/create_admins_table.php' => database_path('migrations/'.$timestamps.'_create_admins_table.php'),
            __DIR__.'/config/backpack/base.php' => config_path('backpack/base.php'),
            __DIR__.'/views/sidebar_content.blade.php' => resource_path('views/vendor/backpack/base/inc/sidebar_content.blade.php'),
            __DIR__.'/app/User.php' => base_path('app/User.php'),
            __DIR__.'/app/Http/Kernel.php' => base_path('app/Http/Kernel.php'),
            __DIR__.'/config/filesystems.php' => config_path('filesystems.php'),
        ], 'ikami-pkg');
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