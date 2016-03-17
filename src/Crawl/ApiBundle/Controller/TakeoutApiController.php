<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/3/17
 * Time: PM6:34
 */

namespace Crawl\ApiBundle\Controller;


use Crawl\ApiBundle\Controller\Abstracts\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TakeoutApiController
 * @package Crawl\ApiBundle\Controller
 */
class TakeoutApiController extends AbstractController
{
    /**
     * @param Request $request
     * @param $place
     * @return JsonResponse
     */
    public function restaurantsApiAction(Request $request, $place)
    {
        $baseUrl = 'https://www.ele.me/restapi/v4/restaurants';

        $curlHelper = $this->get('crawl_common.helper.curl');
        $takeoutHelper = $this->get('crawl_common.helper.takeout');

        $allData = $takeoutHelper->getAllData($baseUrl, $place, $curlHelper);
        $data = ['place' => $place];
        $takeoutHelper->getRestaurants($allData, $data);

        return new JsonResponse($data);
    }

    public function restaurantFoodsApiAction(Request $request, $place, $restaurant)
    {
        $baseUrl = 'https://www.ele.me/restapi/v4/restaurants';

        $curlHelper = $this->get('crawl_common.helper.curl');
        $takeoutHelper = $this->get('crawl_common.helper.takeout');

        $allData = $takeoutHelper->getAllData($baseUrl, $place, $curlHelper);
        $data = ['place' => $place];
        $takeoutHelper->getRestaurants($allData, $data);
        $takeoutHelper->findFootsByRestaurant($data, $curlHelper, $restaurant);

        return new JsonResponse($data);
    }

}