<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/3/14
 * Time: 下午4:35
 */

namespace Crawl\ApiBundle\Controller;

use Crawl\ApiBundle\Controller\Abstracts\AbstractController;
use HtmlParser\ParserDom;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class WorkApi
 * @package Crawl\CommonBundle\Controller
 */
class WordApiController extends AbstractController
{

    /**
     * @param Request $request
     * @param $word
     * @return JsonResponse
     */
    public function apiAction(Request $request, $word)
    {
        $url = self::ACIBA_BASE_URL . $word;

        $curlHelper = $this->get('crawl_common.helper.curl');
        $wordHelper = $this->get('crawl_common.helper.word');
        $wordService = $this->get('crawl_common.service.word');

        $body = $curlHelper->curlByUrl($url);

        // 解析开始
        $dom = new ParserDom($body);
        $data = ['word' => $word];
        $infoDom = $dom->find('.result-info', 0);

        $wordHelper->speak($infoDom, $data);
        $wordHelper->rate($infoDom, $data);
        $wordHelper->translation($infoDom, $data);
        $wordHelper->shapes($infoDom, $data);
        $wordHelper->collins($dom, $data);

        if ($this->getParameter('database_driver') == 'pdo_mysql') {
            //存入Mysql数据库
            $wordService->save($data);
        } else if ($this->getParameter('database_driver') == 'pdo_mysql') {
            //存入本地MongoDB数据库
            $host = $this->getParameter('mongo_db_host');
            $port = $this->getParameter('mongo_db_port');
            $wordService->saveToMongoDB($data, $host, $port);
        }

        return new JsonResponse($data);
    }
}