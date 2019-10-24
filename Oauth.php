<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use function GuzzleHttp\json_decode;

require 'vendor/autoload.php';

class OAuth2{
    
    private $authorizationUri;

   
    private $tokenCredentialUri;

    
    private $redirectUri;

    
    private $clientId;

    
    private $clientSecret;

    
    private $state;

   
    private $code;

       
    private $accessToken;


    private $grantType;
    
    public function __construct(array $config)
    {
        $opts = array_merge([
            'authorizationUri' => null,
            'tokenCredentialUri' => null,
            'redirectUri' => null,
            'clientId' => null,
            'clientSecret'=>null,
            'code'=>null,
            'grantType'=>null
        ], $config);
        
        $this->authorizationUri = $opts['authorizationUri'];
        $this->tokenCredentialUri = $opts['tokenCredentialUri'];
        $this->redirectUri = $opts['redirectUri'];
        $this->clientId = $opts['clientId'];
        $this->clientSecret = $opts['clientSecret'];
        $this->code = $opts['code'];
        $this->grantType = $opts['grantType'];
    }

        
    public function fetchAuthToken()
    {
        $query_params =[
            'code' => $this->getCode(),
            'grant_type' => $this->getGrantType(),
            'redirect_uri' => $this->getRedirectUri(),
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret()
        ];

        $client = new GuzzleHttp\Client(["base_uri" => "https://api.dropbox.com"]);
        
        try{
            $response = $client->post("/oauth2/token",['query'=>$query_params]);
            $r = json_decode($response->getBody(),true);
            return $r;
        }catch(GuzzleException $e){
            echo $e;
        }
        
    }

    


    
    public function setAuthorizationUri($uri)
    {
        $this->authorizationUri = $this->coerceUri($uri);
    }

    
    public function getAuthorizationUri()
    {
        return $this->authorizationUri;
    }

    
    public function getTokenCredentialUri()
    {
        return $this->tokenCredentialUri;
    }

    
    public function setTokenCredentialUri($uri)
    {
        $this->tokenCredentialUri = $this->coerceUri($uri);
    }

    
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    
    public function setRedirectUri($uri)
    {
        
        $this->redirectUri = (string)$uri;
    }

    
    
    public function getState()
    {
        return $this->state;
    }

    
    public function setState($state)
    {
        $this->state = $state;
    }

   
    public function getCode()
    {
        return $this->code;
    }

    
    public function setCode($code)
    {
        $this->code = $code;
    }

    
   
    public function getClientId()
    {
        return $this->clientId;
    }

    
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    

   
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function setGrantType($grant)
    {
        $this->grantType = $grant;
    }

    public function getGrantType()
    {
        return $this->grantType;
    }

    
}
