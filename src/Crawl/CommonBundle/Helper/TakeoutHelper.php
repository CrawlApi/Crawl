<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/3/17
 * Time: PM6:31
 */

namespace Crawl\CommonBundle\Helper;


use HtmlParser\ParserDom;

/**
 * Class TakeoutHelper
 * @package Crawl\CommonBundle\Helper
 */
class TakeoutHelper
{
    /**
     * @param $baseUrl
     * @param $place
     * @param \Crawl\CommonBundle\Helper\CurlHelper $curlHelper
     * @param int $offset
     * @return array
     */
    public function getAllData($baseUrl, $place, $curlHelper, $offset = 0)
    {
        $data = [];
        while (1) {
            $url = $baseUrl . '?geohash=' . $place . '&offset=' . $offset . '&type=geohash';
            if ($curlHelper->curlByUrl($url) != '[]') {
                // 解析开始
                $dom = new ParserDom($curlHelper->curlByUrl($url));
                $stringToArrayDom = json_decode($dom->getPlainText());
                foreach ($stringToArrayDom as $value) {
                    array_push($data, $value);
                }
                $offset = $offset + 24;
            } else {
                break;
            }
        }
        return $data;
    }

    /**
     * @param $dom
     * @param array $data
     */
    public function getRestaurants($dom, array &$data)
    {
        $data['restaurants'] = [];
        foreach ($dom as $value) {
            array_push($data['restaurants'], array(
                'id' => $value->id,
                'name' => $value->name,
                'rating' => $value->rating,
                'month_sales' => $value->month_sales,
                'latitude' => $value->latitude,
                'longitude' => $value->longitude,
                'address' => $value->address,
                'foods' => null
            ));
        }
    }


    /**
     * @param array $data
     * @param \Crawl\CommonBundle\Helper\CurlHelper $curlHelper
     */
    public function findFoots(array &$data, $curlHelper)
    {
        foreach ($data['restaurants'] as $k => $v) {
            $id = $v['id'];
            $url = 'https://www.ele.me/restapi/v4/restaurants/' . $id . '/mutimenu';
            $dom = new ParserDom($curlHelper->curlByUrl($url));
            $stringToArrayDom = json_decode(utf8_decode($dom->getPlainText()));
            $data['restaurants'][$k]['foods'] = $this->getFoots($stringToArrayDom);
        }
    }

    /**
     * @param array $data
     * @param \Crawl\CommonBundle\Helper\CurlHelper $curlHelper
     * @param $restaurant
     */
    public function findFootsByRestaurant(array &$data, $curlHelper, $restaurant)
    {
        $url = 'https://www.ele.me/restapi/v4/restaurants/' . $restaurant . '/mutimenu';
        $dom = new ParserDom($curlHelper->curlByUrl($url));
        $stringToArrayDom = json_decode(utf8_decode($dom->getPlainText()));
        $data['restaurant']['foods'] = $this->getFoots($stringToArrayDom);
    }


    /**
     * @param $foods
     * @return array
     */
    public function getFoots($foods)
    {
        $data = [];
        foreach ($foods as $value) {
            if (isset($value->id)) {
                foreach ($value->foods as $foods) {
                    if ($foods->specfoods[0]->price >= 1) {
                        array_push($data, array(
                            'name' => $foods->specfoods[0]->name,
                            'rating' => $foods->rating,
                            'monthSales' => $foods->month_sales,
                            'price' => $foods->specfoods[0]->price
                        ));
                    }
                }
            }
        }
        return $data;
    }
}