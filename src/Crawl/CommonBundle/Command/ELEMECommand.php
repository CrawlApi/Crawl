<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/3/17
 * Time: PM2:37
 */

namespace Crawl\CommonBundle\Command;


use HtmlParser\ParserDom;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ELEMECommand
 * @package Crawl\CommonBundle\Command
 */
class ELEMECommand extends ContainerAwareCommand
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('crawl:eleme')
            ->addArgument('place', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $place = $input->getArgument('place');
        $baseUrl = 'https://www.ele.me/restapi/v4/restaurants';

        $output->writeln([
            sprintf('PLACE: <comment>%s</comment>', $place),
            sprintf('URL : <comment>%s</comment>', $baseUrl)
        ]);

        $curlHelper = $this->getContainer()->get('crawl_common.helper.curl');

        $allData = $this->getAllData($baseUrl, $place, $curlHelper);
        $data = ['place' => $place];
        $this->getRestaurants($allData, $data);
        $this->findFoots($data);
    }

    /**
     * @param $baseUrl
     * @param $place
     * @param int $offset
     * @param \Crawl\CommonBundle\Helper\CurlHelper $curlHelper
     * @return array|null
     */
    public function getAllData($baseUrl, $place, $curlHelper, $offset = 0)
    {
        $data = [];
        while (1) {
            $url = $baseUrl . '?geohash=' . $place . '&offset=' . $offset . '&type=geohash';
            if ($curlHelper->curlByUrl($url) != '[]') {
                // 解析开始
                $dom = new ParserDom($curlHelper->curlByUrl($url));
                $stringToArrayDom = json_decode($dom->getPlainText());
                foreach ($stringToArrayDom as $value) {
                    array_push($data, $value);
                }
                $offset = $offset + 24;
            } else {
                break;
            }
        }
        return $data;
    }

    /**
     * @param $dom
     * @param array $data
     */
    public function getRestaurants($dom, array &$data)
    {
        $data['restaurants'] = [];
        foreach ($dom as $value) {
            array_push($data['restaurants'], array(
                'id' => $value->id,
                'name' => $value->name,
                'rating' => $value->rating,
                'latitude' => $value->latitude,
                'longitude' => $value->longitude,
                'address' => $value->address,
                'foods' => null
            ));
        }
    }

    /**
     * @param array $data
     */
    public function findFoots(array &$data)
    {
        foreach ($data['restaurants'] as $k => $v) {
            $id = $v['id'];
            $curlHelper = $this->getContainer()->get('crawl_common.helper.curl');
            $url = 'https://www.ele.me/restapi/v4/restaurants/' . $id . '/mutimenu';
            $dom = new ParserDom($curlHelper->curlByUrl($url));
            $stringToArrayDom = json_decode($dom->getPlainText());
            $this->getFoots($stringToArrayDom, $data['restaurants'][$k]);
        }
        $data['restaurants'] = [];
    }

    /**
     * @param $foods
     * @param $data
     */
    public function getFoots($foods, &$data)
    {
        $data['foods'] = [];
        foreach ($foods as $value) {
            if (isset($value->id)) {
                foreach ($value->foods as $foods) {
                    var_dump($foods);
                    if ($foods->specfoods[0]->price >= 1) {
                        array_push($data['foods'], array(
                            'name' => $foods->specfoods[0]->name,
                            'rating' => $foods->rating,
                            'monthSales' => $foods->month_sales,
                            'price' => $foods->specfoods[0]->price
                        ));
                    }
                }
            }
        }
    }

}