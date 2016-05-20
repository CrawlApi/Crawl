<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/5/20
 * Time: PM3:57
 */

namespace Crawl\ApiBundle\Controller;


use Crawl\CommonBundle\Helper\ClientHelper;
use GuzzleHttp\Client;
use HtmlParser\ParserDom;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class InstagramApiController
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
     *          "description"="instagram username"
     *      }
     *  },
     * )
     * @param string $username
     * @return JsonResponse
     */
    public function profileApiAction($username)
    {

        $clientHelper = new ClientHelper();
        $url = 'https://www.instagram.com/web/search/topsearch/?context=blended&query=' . $username;
        $dom = new ParserDom($clientHelper->body($url));
        $stringToArrayDom = json_decode($dom->getPlainText());
        $pk = null;
        foreach ($stringToArrayDom->users as $k => $v) {
            if ($v->user->username == $username) {
                $pk = $v->user->pk;
            }
        }
        $profileApi = "https://i.instagram.com/api/v1/users/" . $pk . "/info/";
        $dom = new ParserDom($clientHelper->body($profileApi));
        return new Response($dom->getPlainText());
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="This is a description of your API method",
     *  requirements={
     *      {
     *          "name"="username",
     *          "dataType"="string",
     *          "requirement"="^[a-z]+$",
     *          "description"="instagram username"
     *      }
     *  },
     * )
     * @param string $username
     * @return JsonResponse
     */
    public function postApiAction($username)
    {
        $clientHelper = new ClientHelper();
        $url = 'https://www.instagram.com/' . $username . '/media/';
        $dom = new ParserDom($clientHelper->body($url));
        $stringToArrayDom = json_decode($dom->getPlainText());
        if ($stringToArrayDom->status == "ok") {
            return new JsonResponse($stringToArrayDom->items);
        }
        return new JsonResponse([]);
    }
}