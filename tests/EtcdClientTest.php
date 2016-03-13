<?php
require "../../ConMate/src/EtcdClient.php";
/**
 * Created by PhpStorm.
 * User: prateeknayak
 * Date: 12/03/2016
 * Time: 23:06
 */
class EtcdClientTest extends PHPUnit_Framework_TestCase
{
    const ETCD_HOST = "http://192.168.99.100:14001";

    /**  @var \Wbd\ConMate\EtcdClient */
    private $client;

    public function setup() {
        $this->client = new \Wbd\ConMate\EtcdClient(self::ETCD_HOST);
    }

    public function testBuildURL() {
        $key = 'mykey';
        $url = $this->client->buildURL($key);
        $this->assertNotEmpty($url);
        $this->assertEquals(self::ETCD_HOST . "/v" . $this->client->getEtcdVersion() . "/keys/" . $key ."/" , $url);


    }

    public function testGetKeyDetails() {
        $json  = "{\"action\":\"get\",\"node\":{\"key\":\"/mykey\",\"value\":\"this is awesome\",\"modifiedIndex\":4,\"createdIndex\":4}}";
        $mykey = $this->client->getKeyDetails('mykey');
        $this->assertJson($json, $mykey);

        $jsonObject = json_decode($mykey);
        $this->assertEquals($jsonObject->node->key, "/mykey");
        $this->assertEquals($jsonObject->node->value, "this is awesome");
    }

    public function testGetValueForKey() {
        $value = $this->client->getValueForKey('mykey');
        $this->assertEquals("this is awesome", $value);
    }

}
