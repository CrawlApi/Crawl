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

        $em = $this->get("doctrine.orm.default_entity_manager");

        //检查数据库是否有数据
        $wordData = $this->checkDBDateByWord($word, $wordService);
        if (count($wordData))
            return new JsonResponse($wordData);

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

        if ($this->getParameter('mongo_db')) {
            //存入本地MongoDB数据库
            $host = $this->getParameter('mongo_db_host');
            $port = $this->getParameter('mongo_db_port');
            $wordService->saveToMongoDB($data, $host, $port);
            $wordData = $wordService->findDataByWordInMongoDB($word);
        } else if ($this->getParameter('database_driver') == 'pdo_mysql') {
            //存入Mysql数据库
            $wordService->save($data);
            $wordData = $em->getRepository('CrawlCommonBundle:Word')->findByWord($word);
        }

        return new JsonResponse($wordData);
    }

    /**
     * @param $word
     * @param \Crawl\CommonBundle\Service\WorkService $wordService
     * @return array|null
     */
    public function checkDBDateByWord($word, $wordService)
    {
        $wordData = [];
        if ($this->getParameter('mongo_db')) {
            $wordData = $wordService->findDataByWordInMongoDB($word);
        } elseif ($this->getParameter('database_driver') == 'pdo_mysql') {
            $em = $this->get("doctrine.orm.default_entity_manager");
            $wordData = $em->getRepository('CrawlCommonBundle:Word')->findByWord($word);
        }
        if (count($wordData))
            return $wordData;
        else
            return [];
    }
}