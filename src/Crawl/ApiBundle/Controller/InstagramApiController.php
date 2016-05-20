<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/5/20
 * Time: PM3:57
 */

namespace Crawl\ApiBundle\Controller;


use Crawl\ApiBundle\Controller\Abstracts\AbstractController;
use Crawl\CommonBundle\Helper\ClientHelper;
use GuzzleHttp\Client;
use HtmlParser\ParserDom;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InstagramApiController extends AbstractController
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
     *      },
     *      {
     *          "name"="quantity",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="instagram posts quantity"
     *      }
     *  },
     * )
     * @param string $username
     * @param Request $request
     * @return JsonResponse
     */
    public function postApiAction(Request $request, $username)
    {
        $quantity = $request->query->get('quantity');
        $clientHelper = new ClientHelper();
        $baseUrl = 'https://www.instagram.com/' . $username . '/media/';
        $id = null;
        $data = [];
        while (1) {
            $url = $baseUrl . '?max_id=' . $id;
            $dom = new ParserDom($clientHelper->body($url));
            $stringToArrayDom = json_decode($dom->getPlainText());
            if ($stringToArrayDom->status == "ok" && !empty($stringToArrayDom->items)) {
                foreach ($stringToArrayDom->items as $k => $item) {
                    if ($quantity !== null && $quantity >= 0 && $quantity == $k) {
                        return new JsonResponse($data);
                    }
                    array_push($data, $item);
                }
                $id = $stringToArrayDom->items[count($stringToArrayDom->items) - 1]->id;
            } else {
                break;
            }
        }
        return new JsonResponse($data);
    }
}