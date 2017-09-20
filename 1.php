# 跳转到个人主页
{hpersonalurl($userinfo['uid'])}

# 根据uid获取用户信息
$user=srv_uc_user::I()->getUserInfo($uid);

# 跳转指定链接
{hurl('uc','index','init',array('id' => $row['uid']))}

# hrloo56跳转
{hnewurl('special', 'partner', 'home')}

# 二维码生成
$img_code = hurl('api', 'index', 'qbcode', array('text' => $url));

# 登陆公共方法
if (!$this->_islogin()) {
    hheaderLocation(hlogin_url());
}

# 获取个人头像
{havatarurl($row['uid'],'middle',$row['avatarver'])}

# 获取当前用户登陆信息
$user =	srv_uc_session::I()->user();

# 日志写入
fx_log::logs2file(__FILE__, __FUNCTION__, $_GET, $_POST, sprintf('写入专家总结数据 %s 条!', $i) , '', fx_utl::hip(false));

# 切取长度用
hcut_utf8($arr_content['content'], 15, "...")

# 模板中判断是否登陆
{if $this->_islogin()}
    登陆后方法
{else}
    <div class="login"><a href="{hlogin_url()}">登录</a></div>
{/if}


# 根据UID补全 nickname avatarver
srv_uc_user::I()->fill_userinfo($course['data'], array('nickname', 'avatarver'));

# 模板中传参数 home/course 模板路径
$course_plhtml=$this->_widget('home', 'course', array('course'=>$course), true);

# 判断是否手机
if(fx_utl::checkmobile()){
}

# 富文本编辑框
<textarea id="case" name="case" style="width:470px;height:380px;"><?php echo $data['case'] ?></textarea>
<?php echo form::editor('case')?>

# 图片上传
<?php echo form::images('photo','photo', $data['photo'] ) ?> <input type="button" onClick="del('photo')" value="删除">

# 时间戳转日期
date('Y-m-d H:i:s', $data['stime'])

# 文件上传
<?php echo form::upfiles('data[zl_url]', 'zl_url', $info['zl_url'])?>

# 事务开启（2个以上的SQL,使用事务）  失败后回滚 $this->mdb->rollback();
$this->mdb->begintrans();
$this->mdb->insert(self::$_table1, $data); 
$this->mdb->insert(self::$_table2, $data);
$this->mdb->commit();

# 缓存
define('CACHE_USER_EXPERIENCE_EVENT', 'user_experience_event/');
# 设置
$this->cache->set($key, $value, 24 * 3600);
# 删除
$this->cache->rm(CACHE_USER_EXPERIENCE_EVENT . $uid);
# 获取
$this->cache->get(CACHE_USER_EXPERIENCE_EVENT . $uid);

# 碎片
$mfb_desc = srv_hs_admin::I()->getblock_byid('105');
srv_hs_admin::I()->updateblock(105, $data); 

$user=srv_uc_user::I()->getUserInfo($uid);

# 二微码生成
$img_code = hurl('api', 'index', 'qbcode', array('text' => $url));
发邮件

private function send_mail()
{
    $email    = 'xxxx@qq.com';
    $title    = '你提交的意见反馈收到了新的回复';
    $content  = '这里是内容';
    $smtplist = srv_hs_config::I()->get_smtp_byemail($email);
    if (!$smtplist) {
	throw new fx_exception('未找到邮件服务器，邮件服务器配置是否正确，是否所有邮箱已经满？');
    }
    fx_mail_phpmailer::I()->send_email_use_smtplist(&$smtplist, $email, $title, $content);
    srv_hs_config::I()->write_smpt_sendlog($smtplist, $email, '这里写昵称', 0, $content);
}
发送微信模板消息  消息字数不能超过20个字

public function send_msg()
{
	$template_data   = '{
	   "touser":"odWKtjjU084yQD6cztD2CCCyEQz0",
	   "template_id":"dq5xXAxJOlmS2zA80CjLAXfxyl9nGVWg3QYXVKMkz6s",
	   "url":"http://m.hrloo.com/dk/71962-k14025968",
	   "data":{
			   "first": {
				   "value":"您好，你有一篇订阅文章！\n",
				   "color":"#173177"
			   },
			   "keyword1":{
				   "value":"2016-10-20 07:31",
				   "color":"#FF0000"
			   },
			   "keyword2": {
				   "value":"红尘醉弥勒徐胜华",
				   "color":"#173177"
			   },
			   "keyword3": {
				   "value":"领导的承诺就像女人的脸，都是假的！",
				   "color":"#173177"
			   },
			   "remark":{
				   "value":"先说咱的观点，如果是我，那必须选择走！这个没得商量！就像男女关系一样，你对我不好，就不要怪别人对我好...",
				   "color":"#173177"
			   }
	   }
   }';

	srv_weixin_index::I()->send_msg($template_data);
}
