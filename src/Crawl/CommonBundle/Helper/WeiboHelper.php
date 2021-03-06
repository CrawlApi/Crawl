<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/5/21
 * Time: PM5:49
 */

namespace Crawl\CommonBundle\Helper;


/**
 * Class WeiboHelper
 * @package Crawl\CommonBundle\Helper
 */
class WeiboHelper
{
    /**
     * 获取Weibo Uid
     *
     * @param $nickname
     * @return null
     */
    public function findUidByNickname($nickname)
    {
        $ch = curl_init();//初始化一个CURL会话
        curl_setopt($ch, CURLOPT_URL, "http://open.weibo.com/widget/ajax_getuidnick.php");//设置CURL请求URL
        $data = "nickname=" . urlencode($nickname);//设置POST数据（用户昵称）
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.8.0.11)  Firefox/1.5.0.11;");//设置User-Agent
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $header = array();
        $header [] = 'Accept-Language: zh-cn';
        $header [] = 'Pragma: no-cache';
        $header [] = 'Referer: http://open.weibo.com/widget/followbutton.php';//经测试，请求必须有Referer，否则将返回NULL
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $page = curl_exec($ch);//运行抓取
        $matches = json_decode($page, true);//将页面返回的json数据解析为数组
        curl_close($ch);

        if (empty($matches['data'])) {//判断返回的UID是否为空
            return null;
        } else {
            return $matches['data'];
        }
    }

}