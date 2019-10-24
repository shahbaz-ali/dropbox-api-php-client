# dropbox-api-php-client
A PHP client library for Oauth2 Authentication And accessing Dropbox APIs

Lead Maintainer: [Shahbaz Ali](https://github.com/shahbaz-ali)

Collaborators : [Azmat Fayaz](https://github.com/AzmatFayaz), [Majid Kundroo](https://github.com/kundroomajid), [Naffi Ahanger](https://github.com/naffi192123)

## Basic Example
> Authentication with OAuth2

    require 'dropbox-api-client.php';

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
    }
