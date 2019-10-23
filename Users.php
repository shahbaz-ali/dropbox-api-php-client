<?php

/**
 * This a User class meant for access and retreival of information from 
 * Dropbox api's related to 'users' endpoints 
 * visit https://www.dropbox.com/developers/documentation/http/documentation#users-get_account
 * for more info !
 * *
 * PHP version 7
 *
 *
 * @category   -
 * @package    -
 * @author     Shahbaz Ali <shahbaz.ali03@gmail.com>
 * @copyright  2019 https://github.com/shahbaz-ali/dropbox-api-php-client
 * @version    0.0.1
 */

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;

require 'vendor/autoload.php';

class Users{
    private $config;


    /**
     * Constructor function for User class
     * 
     * @param array $config  '$config is an array containing information
     * about the access_token and account_id, it must be of the for     
     * ['access_token'=>'xhadyedwjhu&3e2hhBBUy','account_id'=>'dbid:AJHJ4f99T0taONIb-OywGRopQngcdskj']'
     * 
     */

    public function __construct(array $config = array())
    {
        $this->config = array_merge(
            [
                'Authorization'=>'Bearer '.$config['access_token'],
                'Content-Type'=>'application/json'
            ],
            $config);
    }

    /**
     * getUserAccountDetails() is a fucntion for route "/get_account"
     * @return json string containing following information
     * 
     * https://api.dropboxapi.com/2/users/get_account
     * 
     * 
     * Array
     *   (
     *       [account_id] => dbid:xxxxxxxxxxxxxxxxx
     *       [name] => Array
     *           (
     *               [given_name] => Shahbaz
     *               [surname] => Ali
     *               [familiar_name] => Shahbaz
     *               [display_name] => Shahbaz Ali
     *               [abbreviated_name] => SA
     *           )

     *       [email] => s********@gmail.com
     *       [email_verified] => 1
     *       [profile_photo_url] => https://....
     *       [disabled] => 
     *       [is_teammate] => 1
     *   )
     * 
     * 
     */
    public function getUserAccountDetails(){

        $client = new GuzzleHttp\Client(["base_uri" => "https://api.dropbox.com"]);
        
        try{
            $response = $client->post("/2/users/get_account",array(
                'headers'=>[
                    'Authorization'=>$this->config['Authorization'],
                    'Content-Type' =>$this->config['Content-Type']
                ],
                'body'=>json_encode(['account_id'=>$this->config['account_id'],])
            ));
            $r = json_decode($response->getBody(),true);
            return print_r($r,true);
        }catch(GuzzleException $e){
            echo $e;
        }
    }
}
