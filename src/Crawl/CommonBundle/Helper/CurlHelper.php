<?php

/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/3/7
 * Time: 下午2:30
 */
class CurlHelper
{

    /**
     * @param string $url
     * @return mixed
     */
    public function curlByUrl($url)
    {
        $s = curl_init();
        curl_setopt($s, CURLOPT_URL, $url);
        curl_setopt($s, CURLOPT_HEADER, false);
        curl_setopt($s, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($s);
        curl_close($s);

        return $result;
    }
}