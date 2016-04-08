<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/4/7
 * Time: PM12:11
 */

namespace Crawl\CommonBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

class RestaurantsDataSaveDBCommand extends ContainerAwareCommand
{

    const ELEME_BASE_URL = 'https://www.ele.me/restapi/v4/restaurants';

    protected function configure()
    {
        $this
            ->setName('crawl:eleme:save')
            ->addArgument('place', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $place = $input->getArgument('place');
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $con = $em->getConnection();
        $platform = $con->getDatabasePlatform();

        $baseUrl = self::ELEME_BASE_URL;

        $takeoutHelper = $this->getContainer()->get('crawl_common.helper.takeout');
        $restaurantService = $this->getContainer()->get('crawl_common.service.restaurant');
        try {
            //Truncate Restaurant foods
            $con->executeUpdate($platform->getTruncateTableSQL('crawl_restaurant_foods', true));
            //Delete Restaurant
            $em->createQuery('DELETE FROM CrawlCommonBundle:Restaurants')->execute();
            $allData = $takeoutHelper->getAllData($baseUrl, $place);
            $data = ['place' => $place];
            $takeoutHelper->getRestaurants($allData, $data);
            $restaurantService->saveRestaurants($data);

            foreach ($data['restaurants'] as $k => $restaurant) {
                $food = [];
                $id = $restaurant['id'];
                $takeoutHelper->findFootsByRestaurant($food, $id);
                $restaurantService->saveRestaurantFoods($id, $food['restaurant']['foods']);
            }
        } catch (\Exception $e) {
            $output->writeln('import restaurants again');
            $kernel = $this->getContainer()->get('kernel');
            $application = new Application($kernel);
            $application->setAutoExit(false);

            $input = new ArrayInput(array(
                'command' => 'crawl:eleme:save',
                'place' => 'webxpz39m7f'
            ));

            $outputNew = new BufferedOutput();
            $application->run($input, $outputNew);
        }

        $output->writeln('import restaurants and foods success');
    }

}