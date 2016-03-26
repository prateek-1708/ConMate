<?php
/**
 * This class connects to etcd to fetch particular key
 *
 * User: prateeknayak
 * Date: 12/03/2016
 * Time: 22:20
 */

namespace Wbd\ConMate;

/**
 * Class EtcdClient
 * @package Wbd\ConMate
 */
class EtcdClient
{
    const VERSION_SEGMENT = "v";
    const KEYS_SEGMENT = "keys";
    const URL_SEPARATOR = "/";

    private $etcdURL;
    private $etcdVersion;
    private $curlConnect;
    /**
     *
     * EtcdClient constructor.
     * Should be made static ??
     *
     * @param $url mixed ETCD host url
     * @param int $etcdVersion version of etcd api being used
     */
    public function __construct($url, $etcdVersion = 2) {
        $this->etcdURL = $url;
        $this->etcdVersion = $etcdVersion;
        $this->curlConnect = CurlConnect::getInstance();
    }

    /**
     * Get etcd key with all information.
     *
     * @param $key mixed key to retrieve
     * @return mixed Key information.
     */
    public function getKeyDetails($key) {
        $url = $this->buildURL($key);
        return  $this->curlConnect->getCall(array("url" => $url));
    }

    /**
     * Return the value stored in etcd agains requested key.
     * @param $key mixed key for which value needs to be retrieved
     * @return mixed value stored in etcd
     */
    public function getValueForKey($key) {
        $json = json_decode($this->getKeyDetails($key));
        return $json->node->value;
    }

    public function setValueForKey($key, $value) {

    }

    public function setKeyFromSeed($seedJson) {

    }

    /**
     * Build base url against which url for specific key would be built.
     *  e.g. http://localhost:14001/v2/keys/
     *
     * @return string URL to access
     */
    public function buildBaseURL() {
        $baseURL = $this->etcdURL;
        $baseURL .= self::URL_SEPARATOR;
        $baseURL .= self::VERSION_SEGMENT . $this->etcdVersion;
        $baseURL .= self::URL_SEPARATOR;
        $baseURL .= self::KEYS_SEGMENT;
        $baseURL .= self::URL_SEPARATOR;
        return $baseURL;
    }

    /**
     * Build complete Curl URL for a given key XYZ
     *  e.g. http://localhost:14001/v2/keys/XYZ
     *
     * @param $key mixed
     * @return string complete url to fire Curl request against.
     */
    public function buildURL($key) {
        $url = $this->buildBaseURL();
        $url .= $key . self::URL_SEPARATOR;
        return $url;

    }

    /**
     * @return mixed
     */
    public function getEtcdURL() {
        return $this->etcdURL;
    }

    /**
     * @param mixed $etcdURL
     */
    public function setEtcdURL($etcdURL) {
        $this->etcdURL = $etcdURL;
    }

    /**
     * @return int
     */
    public function getEtcdVersion() {
        return $this->etcdVersion;
    }

    /**
     * @param int $etcdVersion
     */
    public function setEtcdVersion($etcdVersion) {
        $this->etcdVersion = $etcdVersion;
    }
}