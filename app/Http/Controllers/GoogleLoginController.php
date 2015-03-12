<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

/**
 * Class GoogleLoginController
 * @package App\Http\Controllers
 */
class GoogleLoginController extends Controller
{

  /**
   * @param \App\Services\GoogleLogin $ga
   * @return string
   */
  public function index(\App\Services\GoogleLogin $ga)
  {
    if ($ga->isLoggedIn()) {
      return \Redirect::to('/');
    }

    $loginUrl = $ga->getLoginUrl();

    return "<a href='{$loginUrl}'>login</a>";
  }

  /**
   * @param \App\Services\GoogleLogin $ga
   */
  public function store(\App\Services\GoogleLogin $ga)
  {
    // User rejected the request
    if (\Input::has('error')) {
      dd(\Input::get('error'));
    }

    if (\Input::has('code')) {
      $code = \Input::get('code');
      $ga->login($code);

      return \Redirect::to('/');
    } else {
      throw new \InvalidArgumentException("Code attribute is missing.");
    }//else
  }//login

}
