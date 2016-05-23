<?php
/**
 * Created by PhpStorm.
 * User: Marquis
 * Date: 16/5/22
 * Time: 上午2:03
 */

namespace Crawl\CommonBundle\Command;

use Crawl\CommonBundle\Helper\ClientHelper;
use HtmlParser\ParserDom;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class StudentCommand
 * @package Crawl\CommonBundle\Command
 */
class StudentCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('crawl:data:student');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientHelper = new ClientHelper();
        //获取校友信息
        for ($i = 70000000000; $i < 120000000000; $i++) {
            if (strlen($i) == 11) {
                $i = str_pad(70000000000, 12, 0, STR_PAD_LEFT);
            }
            $this->noGraduation($i, $clientHelper);
        }

        //获取在校数据
        for ($i = 120000000000; $i < 160000000000; $i++) {
            $this->graduation($i, $clientHelper);
        }
    }

    /**
     * @param string $code
     * @param ClientHelper $clientHelper
     */
    public function noGraduation($code, $clientHelper)
    {
        $url = "http://u.zhbit.com/xy_wcj/main.php?sid=" . $code;
        $dom = new ParserDom($clientHelper->body($url));
        $title = $dom->find('head', 0)->find('title', 0)->getPlainText();
        $data = [];
        if (($name = str_replace('的北理故事', '', trim($title))) != '') {
            array_push($data, $name);
            $all = $dom->find('.all', 0);
            //来自
            foreach ($all->find('.img01-text02 div') as $v) {
                array_push($data, str_replace('»珠海', '', trim($v->getPlainText())));
            }
            //学校
            preg_match("/从 (\S+)毕业来到这里/", $all->find('.img02-text01 div', 0)->getPlainText(), $out);
            array_push($data, $out[1]);
            //成绩低
            preg_match("/有低谷，(\S+)<span class=\"b\">(\S+)<\/span><span class=\"s\">分<\/span>/", $all->find('.img05-text02 div', 1)->innerHtml(), $out);
            $data += ["c1" => [$out[1], $out[2]]];
            //成绩高
            preg_match("/有高峰，(\S+)<span class=\"b\">(\S+)<\/span><span class=\"s\">分<\/span>/", $all->find('.img05-text02 div', 2)->innerHtml(), $out);
            $data += ["c2" => [$out[1], $out[2]]];
            //GPA
            preg_match("/GPA<span class=\"b\">(\S+)<\/span>/", $all->find('.img05-text02 div', 3)->innerHtml(), $out);
            array_push($data, $out[1]);
        }
    }

    /**
     * @param string $code
     * @param ClientHelper $clientHelper
     */
    public function graduation($code, $clientHelper)
    {
        $url = "http://u.zhbit.com/typhcl/s_zhbit/main.php?sid=" . $code;
        $dom = new ParserDom($clientHelper->body($url));
        $title = $dom->find('head', 0)->find('title', 0)->getPlainText();
        $data = [];
        if (($name = str_replace('的北理故事', '', trim($title))) != '') {
            array_push($data, $name);
            $all = $dom->find('.all', 0);
            //来自
            foreach ($all->find('.img01-text02 div') as $v) {
                array_push($data, str_replace('»珠海', '', trim($v->getPlainText())));
            }
            $xs = [];
            //学时
            foreach ($all->find('.img04-text02 div') as $k => $v) {
                preg_match("/(\S+)<span class=\"b\">(\S+)<\/span><span class=\"s\">课时<\/span>/", $v->innerHtml(), $out);
                array_push($xs, [$out[1], $out[2]]);
            }
            array_push($data, $xs);

            //成绩低
            preg_match("/有低谷，(\S+)<span class=\"b\">(\S+)<\/span><span class=\"s\">分<\/span>/", $all->find('.img05-text02 div', 1)->innerHtml(), $out);
            $data += ["c1" => [$out[1], $out[2]]];
            //成绩高
            preg_match("/有高峰，(\S+)<span class=\"b\">(\S+)<\/span><span class=\"s\">分<\/span>/", $all->find('.img05-text02 div', 2)->innerHtml(), $out);
            $data += ["c2" => [$out[1], $out[2]]];
            //GPA
            preg_match("/GPA<span class=\"b\">(\S+)<\/span>/", $all->find('.img05-text02 div', 3)->innerHtml(), $out);
            array_push($data, $out[1]);
        }
    }

}