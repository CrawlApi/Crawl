<?php

/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/3/9
 * Time: 下午2:43
 */

namespace Crawl\CommonBundle\Helper;

use HtmlParser\ParserDom;

/**
 * Class WorkHelper
 * @package Crawl\CommonBundle\Helper
 */
class WorkHelper
{
    /**
     * @param ParserDom $dom
     * @param array $data
     */
    public function speak(ParserDom $dom, array &$data)
    {
        $data['speak'] = [];
        $node = $dom->find('.info-base', 0);
        if ($node->find('.base-speak')) {
            foreach ($node->find('.base-speak .new-speak-step') as $v) {
                preg_match("/displayAudio\(\'(\S+)\'\)/", $v->getAttr('onmouseover'), $out);
                array_push($data['speak'], trim($out[1]));
            }
        }
    }

    /**
     * @param ParserDom $dom
     * @param array $data
     */
    public function rate(ParserDom $dom, array &$data)
    {
        $data['rate'] = 0;
        $node = $dom->find('.info-base', 0);
        if ($node->find('.base-word .word-rate')) {
            $data['rate'] = count($node->find('.base-word .word-rate p i.light'));
        }
    }

    /**
     * @param ParserDom $dom
     * @param array $data
     */
    public function translation(ParserDom $dom, array &$data)
    {
        $data['translation'] = [];
        $node = $dom->find('.info-base', 0);
        if ($node->find('.base-list li span.prop')) {
            $baseListNode = $node->find('.base-list', 0);
            /** @var ParserDom $v */
            foreach ($baseListNode->find('li span.prop') as $v) {
                $data['translation'][] = [str_replace('.', '', trim($v->getPlainText()))];
            }
            foreach ($baseListNode->find('li p') as $k => $v) {
                array_push($data['translation'][$k], str_replace(' ', '', trim($v->getPlainText())));
            }
        }
    }

    /**
     * @param ParserDom $dom
     * @param array $data
     */
    public function shapes(ParserDom $dom, array &$data)
    {
        $data['shapes'] = [];
        $node = $dom->find('.info-base', 0);
        if ($node->find('li.change p')) {
            /** @var ParserDom $v */
            $k = -1;
            foreach ($node->find('li.change p') as $v) {
                foreach ($v->node->childNodes as $value) {
                    if ($value->nodeName === "span") {
                        $data['shapes'][] = [str_replace('：', '', trim($value->nodeValue))];
                        $k++;
                    }
                    if ($value->nodeName === "a") {
                        array_push($data['shapes'][$k], trim($value->nodeValue));
                    }
                }
            }
        }
    }

    /**
     * @param ParserDom $dom
     * @param array $data
     */
    public function collins(ParserDom $dom, array &$data)
    {
        $data['collins'] = [];
        $node = $dom->find('.collins-section', 0);
        if ($node) {
            $index = -1;
            $arr = 0;
            foreach ($node->find('div') as $v) {
                //当没有order,设定一个default值
                if ($v->getAttr('class') != 'section-h') {
                    $index = 0;
                }
                if ($v->getAttr('class') == 'section-h') {
                    $index++;
                    $arr = 0;
                    preg_match("/<span (\S+)>(.+)<\/span>(.+)/", $v->find('p', 0)->innerHtml(), $out);
                    $data['collins'][$index]['translation']['en'] = trim($out[2]);
                    $data['collins'][$index]['translation']['zh'] = trim($out[3]);
                    //获取sentence有2种情况
                } elseif ((trim($v->getAttr('class')) == 'section-prep' || trim($v->getAttr('class')) == 'section-prep no-order') && $v->find('p.size-chinese .family-english', 0)) {
                    $arr++;
                    $note = $v->find('p.size-chinese .family-english', 0)->getPlainText() . ' ' . $v->find('p.size-chinese .family-chinese', 0)->getPlainText();
                    $note = $note . ' ' . $v->find('p.size-chinese .size-english', 0)->getPlainText();
                    $data['collins'][$index]['translation'][$arr]['note'] = $note;
                } elseif (trim($v->getAttr('class')) == 'text-sentence') {
                    $sentence = array();
                    foreach ($v->find('.sentence-item ') as $value) {
                        preg_match("/(.+)<i class=\"speak-step\" onmouseover=\"displayAudio\(\'(\S+)\'\)\"><\/i>/", $value->find('p.family-english', 0)->innerHtml(), $out);
                        $sentenceZh = $value->find('p.family-chinese', 0)->getPlainText();
                        array_push($sentence, array(
                            'en' => $out[1],
                            'zh' => trim($sentenceZh),
                            'voice' => $out[2]
                        ));
                    }
                    $data['collins'][$index]['translation'][$arr]['sentence'] = $sentence;
                }
            }
        }
    }

}