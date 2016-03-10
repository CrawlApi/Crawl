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
        $data['speakUK'] = [];
        $node = $dom->find('.info-base', 0);
        if ($node->find('.base-speak')) {
            foreach ($node->find('.base-speak .new-speak-step') as $v) {
                preg_match("/displayAudio\(\'(\S+)\'\)/", $v->getAttr('onmouseover'), $out);
                array_push($data['speakUK'], trim($out[1]));
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
                array_push($data['translation'][$k], trim($v->getPlainText()));
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
            foreach ($node->find('li.change p span') as $v) {
                $data['shapes'][] = [str_replace('：', '', trim($v->getPlainText()))];
            }
            foreach ($node->find('li.change p a') as $k => $v) {
                array_push($data['shapes'][$k], trim($v->getPlainText()));
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
            foreach ($node->find('div') as $v) {
                if ($v->getAttr('class') == 'section-h') {
                    $index++;
                    preg_match("/<span (\S+)>(.+)<\/span>(.+)/", $v->find('p', 0)->innerHtml(), $out);
                    $data['collins'][$index]['translation']['en'] = trim($out[2]);
                    $data['collins'][$index]['translation']['zh'] = trim($out[3]);
                } elseif (trim($v->getAttr('class')) == 'section-prep') {
                    $family = $v->find('p.size-chinese .family-english', 0)->getPlainText() . ' ' . $v->find('p.size-chinese .family-chinese')->getPlainText();
                } elseif (trim($v->getAttr('class')) == 'text-sentence') {
                    //TODO
                }
            }
        }
        var_dump($data);
    }

}