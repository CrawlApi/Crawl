<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/4/7
 * Time: PM12:11
 */

namespace Crawl\CommonBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RestaurantsDataSaveDBCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('crawl:eleme:save')
            ->addArgument('place', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $place = $input->getArgument('place');
    }

}