<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/4/14
 * Time: PM6:16
 */

namespace Crawl\ApiBundle\Controller;


use Crawl\ApiBundle\Controller\Abstracts\AbstractController;
use Crawl\CommonBundle\Helper\DoubleColorBallHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DoubleColorBallApiController extends AbstractController
{
    public function issueApiAction(Request $request, $issue)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $num = $em->getRepository('CrawlCommonBundle:DoubleColorBalls')->findArray($issue);
        //先判断数据库是否有数据
        if ($num) {
            $data = $num;
        } else {
            $baseUrl = "http://www.17500.cn/ssq/details.php?issue=";

            $doubleColorBallHelper = new DoubleColorBallHelper();
            $data = $doubleColorBallHelper->getDataByIssue($baseUrl, $issue);
        }
        return new JsonResponse($data);
    }
}