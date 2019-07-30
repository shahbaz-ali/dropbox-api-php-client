# dropbox-api-php-client
A PHP client library for Oauth2 Authentication And accessing Dropbox APIs

## Basic Example
> Authentication with OAuth

```require 'dropbox-api-client.php';

    $oauth_config = [
        'client_id' => <client id>,
        'redirect_uri' => '<redirect uri>',
    ];
    $client = new Dropbox_Client($oauth_config);
if (isset($_GET['code']) && strlen($_GET['code'])>0){
    /**
     * Authentication 
     */
    $client->setClientSecret(<client secret>);
    $client->authenticate($_GET['code']);
}else{
    /**
     *  Authorization
     */
    $client->authorize();
}```
