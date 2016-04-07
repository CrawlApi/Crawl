<?php
/**
 * ICIBACommand.php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    jack <linjue@wilead.com>
 * @copyright 2007-16/3/7 WIZ TECHNOLOGY
 * @link      http://wizmacau.com
 * @link      http://jacklam.it
 * @link      https://github.com/lamjack
 * @version
 */

namespace Crawl\CommonBundle\Command;

use HtmlParser\ParserDom;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wiz\Parser\ICIBAParser;

class ICIBACommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('crawl:iciba')
            ->addArgument('word', InputArgument::REQUIRED);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $word = $input->getArgument('word');
        $url = 'http://www.iciba.com/' . $word;

        $output->writeln([
            sprintf('WORD: <comment>%s</comment>', $word),
            sprintf('URL : <comment>%s</comment>', $url),
            ''
        ]);

        $ICIBAParser = new ICIBAParser();

        // 解析开始
        $data = $ICIBAParser->query($word);

        var_dump($data);

        return 0;
    }
}