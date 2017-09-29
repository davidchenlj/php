    public function parallel_php()
    {
        $connomains = array(
            'http://www.test.com',
            'http://www.test.com',
        );

        $mh = curl_multi_init();
        foreach ($connomains as $i => $url) {
            $conn[$i] = curl_init($url);
            curl_setopt($conn[$i], CURLOPT_RETURNTRANSFER, 1);
            // 写谷歌浏览器cookie，如果网站没限制就不用
            curl_setopt($conn[$i], CURLOPT_COOKIE, "这里写cookie");
            curl_multi_add_handle($mh, $conn[$i]);
        }
        do {$n = curl_multi_exec($mh, $active);} while ($active);
        foreach ($connomains as $i => $url) {
            $res[$i] = curl_multi_getcontent($conn[$i]);
            curl_close($conn[$i]);
        }
        print_r($res);
    }
