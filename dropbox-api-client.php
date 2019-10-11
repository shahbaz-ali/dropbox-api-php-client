<?php

require 'Oauth.php';
require 'vendor/autoload.php';


class Dropbox_Client
{
  const LIBVER = "0.0.1";
  const USER_AGENT_SUFFIX = "dropbox-api-php-client/";
  const OAUTH2_TOKEN_URI = 'https://api.dropbox.com/oauth2/token';
  const OAUTH2_AUTH_URL = 'https://www.dropbox.com/oauth2/authorize';
  const API_BASE_PATH = 'https://www.dropbox.com';
  const GRANT_TYPE = 'authorization_code';
  
  private $auth;
  
  private $http;
  
  private $cache;
  
  private $token;
  
  private $config;
  
  private $logger;

  private $creds;
  
  
  public function __construct(array $config = array())
  {
    $this->config = array_merge(
        [
          'client_id' => '',
          'redirect_uri' => null,
          'state' => null,
          'response_type' => 'code'
        ],
        $config
    );
  }
  
  public function getLibraryVersion()
  {
    return self::LIBVER;
  }
  
  public function authenticate($code)
  {
    return $this->fetchAccessTokenWithAuthCode($code);
  }

  public function authorize(){
    
    $url = sprintf("Location: %s/?%s",self::OAUTH2_AUTH_URL,http_build_query($this->config));
    header($url);
    exit();
    
  }
 
  public function fetchAccessTokenWithAuthCode($code)
  {
    if (strlen($code) == 0) {
      throw new InvalidArgumentException("Invalid code");
    }
    $auth = $this->getOAuth2Service();
    $auth->setCode($code);
    $auth->setRedirectUri($this->getRedirectUri());
    $this->creds = $auth->fetchAuthToken();
    
  }

  public function getOAuth2Service()
  {
    if (!isset($this->auth)) {
      $this->auth = $this->createOAuth2Service();
    }
    return $this->auth;
  }

  protected function createOAuth2Service()
  {

    $auth = new OAuth2(
        [
          'authorizationUri' => self::OAUTH2_AUTH_URL,
          'tokenCredentialUri' => self::OAUTH2_TOKEN_URI,
          'clientId'          => $this->getClientId(),
          'redirectUri'       => $this->getRedirectUri(),
          'grantType'         => self::GRANT_TYPE,
          'clientSecret'      => $this->getClientSecret()
        ]
    );

    return $auth;
  }

  
  public function setClientId($clientId)
  {
    $this->config['client_id'] = $clientId;
  }
  public function getClientId()
  {
    return $this->config['client_id'];
  }
 
  public function setClientSecret($clientSecret)
  {
    $this->config['client_secret'] = $clientSecret;
  }
  public function getClientSecret()
  {
    return $this->config['client_secret'];
  }
 
  public function setRedirectUri($redirectUri)
  {
    $this->config['redirect_uri'] = $redirectUri;
  }
  public function getRedirectUri()
  {
    return $this->config['redirect_uri'];
  }
  
  public function setState($state)
  {
    $this->config['state'] = $state;
  }

  public function getState(){
    return $this->config['state'];
  }

  public function setResponseType($response_type)
  {
    $this->config['response_type'] = $response_type;
  }

  public function getResponseType(){
    return $this->config['response_type'];
  }

  public function getCredentialsInfoAsAssoc(){
    return $this->creds;
  }


}