<?php

namespace App\Services;

/**
 * Class GoogleLogin
 * @package App\Services
 */
class GoogleLogin
{
  /**
   * @var \Google_Client
   */
  protected $client;

  /**
   * @param \Google_Client $client
   */
  public function __construct(\Google_Client $client)
  {
    $this->client = $client;

    $this->client->setClientId(\Config::get('google.client_id'));
    $this->client->setClientSecret(\Config::get('google.client_secret'));
    $this->client->setDeveloperKey(\Config::get('google.api_key'));
    $this->client->setRedirectUri(\Config::get('app.url') . "/loginCallback");
    $this->client->setScopes([
                                 'https://www.googleapis.com/auth/youtube',
                               /*'https://www.googleapis.com/auth/youtube.readonly',
                               'https://www.googleapis.com/auth/youtubepartner',
                               'https://www.googleapis.com/auth/youtubepartner-channel-audit'*/
                             ]);
    $this->client->setAccessType('offline');
  }

  /**
   * @return string
   */
  public function isLoggedIn()
  {
    if (\Session::has('token')) {
      $this->client->setAccessToken(\Session::get('token'));
    }
    else{
      return false;
    }

    if ($this->client->isAccessTokenExpired()) {
      \Session::set('token', $this->client->getRefreshToken());
    }

    return !$this->client->isAccessTokenExpired();
  }

  /**
   * @param $code
   * @return string
   */
  public function login($code)
  {
    $this->client->authenticate($code);
    $token = $this->client->getAccessToken();
    \Session::put('token', $token);

    return $token;
  }

  /**
   * @return string
   */
  public function getLoginUrl()
  {
    $authUrl = $this->client->createAuthUrl();

    return $authUrl;
  }
}

 