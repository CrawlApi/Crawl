<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/5/21
 * Time: PM2:36
 */

namespace Crawl\ApiBundle\Controller;


use Crawl\ApiBundle\Controller\Abstracts\AbstractController;
use Crawl\CommonBundle\Helper\ClientHelper;
use HtmlParser\ParserDom;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class WeiboApiController
 * @package Crawl\ApiBundle\Controller
 */
class WeiboApiController extends AbstractController
{

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="This is a description of your API method",
     *  requirements={
     *      {
     *          "name"="username",
     *          "dataType"="string",
     *          "requirement"="^[a-z]+$",
     *          "description"="weibo username"
     *      }
     *  },
     * )
     * @param $username
     * @return JsonResponse
     */
    public function profileApiAction($username)
    {
        $clientHelper = new ClientHelper();
        $weiboHelper = $this->get('crawl_common.helper.weibo');
        $uid = $weiboHelper->findUidByNickname($username);
        if ($uid === null)
            return new JsonResponse(["message" => "no user"]);

        $url = 'http://mapi.weibo.com/2/profile?gsid=_&c=&s=&user_domain=' . $uid;
        $stringToArrayDom = json_decode($clientHelper->body($url));

        return new JsonResponse($stringToArrayDom->userInfo);
    }
}