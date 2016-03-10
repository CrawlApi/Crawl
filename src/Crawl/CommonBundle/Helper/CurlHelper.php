<?php

/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/3/7
 * Time: 下午2:30
 */

namespace Crawl\CommonBundle\Helper;
/**
 * Class CurlHelper
 * @package Crawl\CommonBundle\Helper
 */
class CurlHelper
{

    /**
     * @param string $url
     * @return mixed
     */
    public function curlByUrl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $body = curl_exec($ch);

        if (curl_error($ch)) {
            curl_close($ch);
            throw new \LogicException(sprintf('Could not send request: %s', curl_error($ch)));
        }

        $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($resultStatus / 100 != 2) {
            curl_close($ch);
            throw new \LogicException(sprintf('Request failed: error Http Code %s', $resultStatus));
        }
        curl_close($ch);

        return $body;
    }
}