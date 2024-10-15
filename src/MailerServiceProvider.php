<?php
namespace Pondol\Mailer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Blade;




class MailerServiceProvider extends ServiceProvider {


  /**
   * Where the route file lives, both inside the package and in the app (if overwritten).
   *
   * @var string
   */

	/**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {

    if ($this->app->runningInConsole()) {
      $this->commands([
        Console\InstallCommand::class,
      ]);
    }

    // $this->app->singleton('editor', function($app) {
    //   return new Editor;
    // });
  }

	/**
   * Bootstrap any application services.
   *
   * @return void
   */
	public function boot()
  {
    // if (!$this->app->routesAreCached()) {
    //   require_once __DIR__ . '/Https/routes/web.php';
    // }
    // $this->loadRoutesFrom(__DIR__.'/routes/web.php');

    // $this->loadViewsFrom(__DIR__.'/resources/views/editor', 'editor');

    // // set assets
		// $this->publishes([
    //   __DIR__.'/public/plugins/editor/' => public_path('plugins/editor'),
    // ], 'public');


  }


}
