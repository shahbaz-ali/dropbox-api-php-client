<!--Custom Oauth Controller -->
<!-- Author : SA -->
<?php
ini_set('display_error',1);
error_reporting(-1);

require 'dropbox-api-client.php';
    $oauth_config = [
        'client_id' => 'rxl0jjdrg11kjqw',
        'redirect_uri' => 'http://localhost/dropbox-api-php-client/authenticate.php',
    ];
    $client = new Dropbox_Client($oauth_config);

if (isset($_GET['code']) && strlen($_GET['code'])>0){

    /**
     * Authentication 
     */
    $client->setClientSecret('ia8ojtkxdnro9db');
    $client->authenticate($_GET['code']);
}else{
    /**
     *  Authorization
     */
    $client->authorize();
}
