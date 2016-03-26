<?php

namespace Wbd\ConMate;

/**
 * Class CurlConnect
 *
 * Curl utility class to access etcd apis.
 * @package Wbd\ConMate
 */

class CurlConnect
{
    /** @var mixed Info on curl channel */
    private $info;

    /** @var mixed Curl channel being executed  */
    private $channel;

    /** @var CurlConnect instance of curl connect */
    private static $instance = null;

    /**
     * Curlise means to do the usual curl stuff with a request.
     * @param $url mixed curl channel
     * @return bool|mixed
     */
    public function curlise($url, $options = array()){

        $this->init($url);

        $baseOptions = array(
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => 1,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        );
        $this->setOpts($baseOptions);

        // we want to set opts later so that calling function can override defaults
        if (!empty($options)) {
            $this->setOpts($options);
        }
        return  $this->executeAndClose();

    }

    /**
     * Perform get request
     * @param array $params url and curl options if neccessary
     * @return bool|mixed
     */
    public function getCall(Array $params) {
        return $this->curlise($params['url']);
    }

    /**
     * Perform Put request
     *
     * @param array $params url and post data
     * @return bool|mixed
     */
    public function put(Array $params) {
        $options = array (
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER =>  false,
            CURLOPT_POSTFIELDS => $params['post_data'],
        );

        return $this->curlise($params['url'], $options);
    }

    /**
     * Helper method for curlise
     *
     * @param $url
     * @throws \Exception Cannot initialise curl channel
     */
    private function init($url) {
        $this->channel = curl_init($url);
        if (false == $this->channel) {
            throw new \Exception("Cannot initialise curl channel");
        }
    }

    /**
     * Helper method for curlise
     *
     * Calls curl set opt array on options.
     *
     * @param array $options
     * @throws \Exception
     */
    private function setOpts(Array $options) {
        $set = curl_setopt_array($this->channel, $options);
        if (false == $set) {
            throw new \Exception("Cannot set options array on the curl channel");
        }
    }

    /**
     * Helper method for curlise
     *
     * Call exec and close on curl channel.
     * @return mixed
     * @throws \Exception
     */
    private function executeAndClose() {

        // make the call
        $result = curl_exec($this->channel);

        // set info for diagnosis purposes
        $this->info = @curl_getinfo($this->channel);

        // close resource
        curl_close($this->channel);

        if (false == $result) {
            throw new \Exception("Result not found");
        }
        return $result;
    }

    /**
     * Get instance of Curl Connect
     * @return CurlConnect
     */
    public static function getInstance() {
        if (null == self::$instance) {
            self::$instance = new CurlConnect();
        }
        return self::$instance;
    }

    private function __construct() {}
    private function __clone() {}

}