<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/4/8
 * Time: AM10:29
 */

namespace Crawl\CommonBundle\Helper;


use Wiz\Parser\Client;

/**
 * Class ClientHelper
 * @package Crawl\CommonBundle\Helper
 */
class ClientHelper
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * ClientHelper constructor.
     */
    public function __construct()
    {
        $this->client = Client::getInstance();
    }

    /**
     * @param string $link
     * @return array|string
     */
    public function body($link)
    {
        $response = $this->client->request('GET', sprintf('%s', $link), [
            'headers' => [
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Encoding' => 'gzip, deflate',
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:45.0) Gecko/20100101 Firefox/45.0'
            ]
        ]);

        if ($response->getStatusCode() === 200) {
            return $response->getBody()->getContents();
        }

        return array('errCode' => 500, "errMsg" => "服务器请求失败");
    }

}