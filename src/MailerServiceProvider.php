<?php
namespace Pondol\Mailer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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
  }

	/**
   * Bootstrap any application services.
   *
   * @return void
   */
	public function boot()
  {
    if (!config()->has('pondol-mailer')) {
      $this->publishes([
        __DIR__ . '/config/pondol-mailer.php' => config_path('pondol-mailer.php'),
      ], 'config');
    }

    $this->mergeConfigFrom(
      __DIR__ . '/config/pondol-mailer.php',
      'pondol-mailer'
    );

    $this->loadMailerRoutes();

    $this->commands([
      Console\InstallCommand::class,
    ]);


    $this->loadViewsFrom(__DIR__.'/resources/views', 'pondol-mailer');

    // // set assets
		// $this->publishes([
    //   __DIR__.'/resources/pondol/mailer/' => public_path('pondol/mailer'),
    // ], 'public');

    $this->publishes([
      __DIR__.'/resources/views/templates' => resource_path('views/mailer/templates'),
    ]);

    // Register migrations
    $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

  }

  private function loadMailerRoutes()
  {
    $config = config('pondol-mailer');

    Route::prefix($config['prefix'])
      ->as($config['as'])
      ->middleware($config['middleware'])
      ->namespace('Pondol\Mailer')
      ->group(__DIR__ . '/routes/web.php');
  }


}
