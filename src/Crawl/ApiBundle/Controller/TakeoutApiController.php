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
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class TakeoutApiController
 * @package Crawl\ApiBundle\Controller
 */
class TakeoutApiController extends AbstractController
{
    /**
     * @ApiDoc(
     *  resource=true,
     *  description="This is a description of your API method",
     *  requirements={
     *      {
     *          "name"="place",
     *          "dataType"="string",
     *          "requirement"=".*",
     *          "description"="place in map(code)"
     *      }
     *  },
     * )
     * @param Request $request
     * @param $place
     * @return JsonResponse
     */
    public function restaurantsApiAction(Request $request, $place)
    {
        $baseUrl = self::ELEME_BASE_URL;

        $em = $this->getDoctrine()->getEntityManager();

        $takeoutHelper = $this->get('crawl_common.helper.takeout');
        $restaurants = $em->getRepository('CrawlCommonBundle:Restaurants')->findArray();
        if (count($restaurants)) {
            $data = $restaurants;
        } else {
            $allData = $takeoutHelper->getAllData($baseUrl, $place);
            $data = ['place' => $place];
            $takeoutHelper->getRestaurants($allData, $data);
        }

        return new JsonResponse($data);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="This is a description of your API method",
     *  requirements={
     *      {
     *          "name"="place",
     *          "dataType"="string",
     *          "requirement"=".*",
     *          "description"="place in map(code)"
     *      },
     *      {
     *          "name"="restaurant",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="restaurant code"
     *      }
     *  },
     * )
     * @param Request $request
     * @param $place
     * @param $restaurant
     * @return JsonResponse
     */
    public function restaurantFoodsApiAction(Request $request, $place, $restaurant)
    {
        $takeoutHelper = $this->get('crawl_common.helper.takeout');
        $em = $this->getDoctrine()->getEntityManager();

        $restaurantFoods = $em->getRepository('CrawlCommonBundle:RestaurantFoods')->findArray($restaurant);
        if (count($restaurantFoods)) {
            $data = $restaurantFoods;
        } else {
            $data = ['place' => $place];
            $takeoutHelper->findFootsByRestaurant($data, $restaurant);
        }

        return new JsonResponse($data);
    }

}