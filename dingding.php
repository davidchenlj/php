<?php
define('DINGDING_TOKEN_MEMBER', 'dingding_token/id');

/**
 * 微信公绑定账号模块
 * Class srv_spl_dingding
 */
class srv_spl_dingding
{
    private function __construct()
    {
        $this->cache = fx_cache_memcached::I();
    }

    private static $i;

    /**
     * @return srv_spl_dingding
     */
    public static function I()
    {
        if (!isset(self::$i)) {
            self::$i = new self();

        }
        return self::$i;
    }

  

    /**
     * 获取dingding getAccessToken
     */
    public function getAccessToken()
    {
        $corpid='';
        $corpsecret='';
        $url='https://oapi.dingtalk.com/gettoken?corpid=' . $corpid .'&corpsecret=' . $corpsecret;

        $data = $this->cache->get(DINGDING_TOKEN_MEMBER);
        if (!$data) {
            $res=Hcurl($url, "", "get");    
            $this->cache->set(DINGDING_TOKEN_MEMBER, $res['access_token'], 3600);
            return $res['access_token'];
        }
        return $data;
    }

    /**
     * 发送会话消息， 获取userID需要，打开官方下载好的demo，在本地运行php的版本要5.3以上 在手机钉钉访问本地部署才可以取得到，在通过UserID去创建会话得到会话ID.
     * 调用接口创建了2个会话ID chat31cfcb024128683b6bdd18d1917c62e1  chatc9ade29f99314e4bfbdd327697ff9bd9  userID：020005651237820161 黄老板的userID：0003
     * 参考官方 https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7629140.0.0.CXBbPW&treeId=385&articleId=104977&docType=1#s3
     * @param $data json字符串 不需要传array
     */
    public function sendMsg($data){
        $access_token=$this->getAccessToken();
        $res=Hcurl('https://oapi.dingtalk.com/chat/send?access_token=' . $access_token, $data, "post", array('content-type:application/json'));
        return $res;
    }
   
}
