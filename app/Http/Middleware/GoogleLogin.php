<?php namespace App\Http\Middleware;

use Closure;

class GoogleLogin
{

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    $ga = \App::make('\App\Services\GoogleLogin');
    if (!$ga->isLoggedIn()) {
      return redirect('login');
    }

    return $next($request);
  }

}
