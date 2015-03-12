<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class YoutubeServiceProvider extends ServiceProvider
{

  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    //
  }

  /**
   * Register the application services.
   *
   * @return void
   */
  public function register()
  {
    $app = $this->app;

    $this->app->bind('GoogleClient', function () {
      $googleClient = new \Google_Client();
      $googleClient->setAccessToken(\Session::get("token"));

      return $googleClient;
    });

    $this->app->bind('youtube', function () use ($app) {
      $googleClient = \App::make('GoogleClient');
      $youtube = new \Google_Service_YouTube($googleClient);

      return $youtube;
    });
  }

}
