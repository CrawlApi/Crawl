<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/4/13
 * Time: PM7:06
 */

namespace Crawl\CommonBundle\Helper;


class DoubleColorBallHelper
{
    public function getDataByIssue($baseUrl, $issue)
    {
        $clientHelper = new ClientHelper();
        $url = $baseUrl . $issue;
        $dom = $clientHelper->body($url);

        $result = ['issue' => $issue];
        $this->parser($dom, $result);

        return $result;
    }

    public function parser(string $html, array &$result = [])
    {

    }
}