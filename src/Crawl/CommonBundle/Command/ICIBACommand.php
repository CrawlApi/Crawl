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

class ICIBACommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('test:iciba')
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

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $body = curl_exec($ch);

        if (curl_errno($ch)) {
            $output->write(sprintf('<error>Could\'t send request: %s</error>', curl_error($ch)));
            curl_close($ch);
            return 1;
        }

        $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($resultStatus / 100 !== 2) {
            $output->write(sprintf('<error>Request failed: HTTP status code: %s</error>', curl_error($ch)));
            curl_close($ch);
            return 1;
        }

        curl_close($ch);

        // 解析开始
        $dom = new ParserDom($body);
        $data = ['word' => $word];
        $infoDom = $dom->find('.result-info', 0);

        $this->speak($infoDom, $data);
        $this->rate($infoDom, $data);
        $this->shapes($infoDom, $data);
        $this->collins($infoDom, $data);

        //var_dump($data);

        return 0;
    }

    /**
     * @param ParserDom $dom
     * @param array     $data
     */
    protected function speak(ParserDom $dom, array &$data)
    {
        $data['speak'] = [];
        $node = $dom->find('.info-base .base-speak', 0);
        if ($node) {
            foreach ($node->find('.speak-step') as $v) {
                preg_match("/displayAudio\(\'(\S+)\'\)/", $v->getAttr('onmouseover'), $out);
                array_push($data['speak'], trim($out[1]));
            }
        }
    }

    /**
     * @param ParserDom $dom
     * @param array     $data
     */
    protected function shapes(ParserDom $dom, array &$data)
    {
        $data['shapes'] = [];
        $node = $dom->find('.info-base .base-list li.change p', 0);
        if ($node) {
            foreach ($node->find('span') as $v) {
                $data['shapes'][] = [str_replace('：', '', trim($v->getPlainText()))];
            }
            foreach ($node->find('a') as $k => $v) {
                array_push($data['shapes'][$k], trim($v->getPlainText()));
            }
        }
    }

    /**
     * @param ParserDom $dom
     * @param array     $data
     */
    protected function rate(ParserDom $dom, array &$data)
    {
        $data['rate'] = 0;
        $node = $dom->find('.info-base .base-word .word-rate p i.light');
        if ($node) {
            $data['rate'] = count($node);
        }
    }

    protected function collins(ParserDom $dom, array &$data)
    {
        $data['collins'] = [];
        $node = $dom->find('.collins-section', 0);
        if ($node) {
            $index = -1;
            foreach ($node->find('div') as $v) {
                if ($v->getAttr('class') == 'section-h') {
                    $index++;
                    preg_match("/<span (\S+)>(.+)<\/span>(.+)/", $v->find('p', 0)->innerHtml(), $out);
                    $data['collins'][$index]['translation']['en'] = trim($out[2]);
                    $data['collins'][$index]['translation']['zh'] = trim($out[3]);
                } elseif (trim($v->getAttr('class')) == 'section-prep') {

                }
            }
        }
        //var_dump($data['collins']);
    }
}