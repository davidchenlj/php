    /**
     * 微信昵称 表情替换
     * @param $nickname
     */
    public function remove_emoji($nickname)
    {
        $strEncode = '';
        $length    = mb_strlen($nickname, 'utf-8');
        for ($i = 0; $i < $length; $i++) {
            $_tmpStr = mb_substr($nickname, $i, 1, 'utf-8');
            if (strlen($_tmpStr) >= 4) {
                $strEncode .= '[' . rawurlencode($_tmpStr) . ']';
            } else {
                $strEncode .= $_tmpStr;
            }
        }
        $str = preg_replace('/\[.*?\]/', '', $strEncode);
        // 替换所有空格
        return preg_replace('/\s+/','', $str);
    }
