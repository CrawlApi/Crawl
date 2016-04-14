<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/4/13
 * Time: PM7:06
 */

namespace Crawl\CommonBundle\Helper;


use HtmlParser\ParserDom;

/**
 * Class DoubleColorBallHelper
 * @package Crawl\CommonBundle\Helper
 */
class DoubleColorBallHelper
{
    /**
     * @param $baseUrl
     * @param $issue
     * @return array
     */
    public function getDataByIssue($baseUrl, $issue)
    {
        $clientHelper = new ClientHelper();
        $url = $baseUrl . $issue;
        $dom = $clientHelper->body($url);
        //判断是否存在服务器错误
        if (is_array($dom) && array_key_exists("errCode", $dom)) {
            return $dom;
        }
        $result = ['issue' => $issue];
        $this->parser($dom, $result);

        return $result;
    }

    /**
     * @param string $html
     * @param array $result
     */
    public function parser(string $html, array &$result = [])
    {
        $dom = new ParserDom($html);
        $mainContent = $dom->find('table', 4);
        if ($mainContent) {
            foreach ($mainContent->find('tr', 1)->find('td') as $value) {
                array_push($result, $value->getPlainText());
            }
        } else {
            $result = ['errCode' => 404, 'errMsg' => "开奖信息不存在"];
        }
    }
}