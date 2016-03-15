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
        $url = 'http://www.iciba.com/' . $word;

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

        //存入数据库
        $wordService->save($data);

        return new JsonResponse($data);
    }
}