<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/3/17
 * Time: PM2:37
 */

namespace Crawl\CommonBundle\Command;

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
        $takeoutHelper = $this->getContainer()->get('crawl_common.helper.takeout');

        $allData = $takeoutHelper->getAllData($baseUrl, $place, $curlHelper);
        $data = ['place' => $place];
        $takeoutHelper->getRestaurants($allData, $data);
        $takeoutHelper->findFoots($data, $curlHelper);
    }

}