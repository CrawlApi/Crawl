<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/4/14
 * Time: PM12:14
 */

namespace Crawl\CommonBundle\Command;


use Crawl\CommonBundle\Helper\DoubleColorBallHelper;
use Crawl\CommonBundle\Service\DoubleColorBallService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DoubleColorBallCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('crawl:double-color-ball');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $baseUrl = "http://www.17500.cn/ssq/details.php?issue=";

        $doubleColorBallHelper = new DoubleColorBallHelper();
        $doubleColorBallService = $this->getContainer()->get('crawl_common.service.double_color_ball');

        for ($i = 2003001; $i < 2016041; $i++) {
            $result = $doubleColorBallHelper->getDataByIssue($baseUrl, $i);
            if (!array_key_exists('errCode', $result)) {
                $doubleColorBallService->saveNum($result);
                $output->writeln('import ' . $i);
            }
        }
        $output->writeln('import complete');
    }

}