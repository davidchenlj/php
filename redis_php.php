    public function redis_php()
    {
        // key不能重复
        $key       = 'ltest_' . $this->_uid();
        $redis_get = fx_redis_service::I()->get($key);
        if (!$redis_get) {
            // 第一个参数是 key 第2个是失效时间 第3个是VALUE
            $redis_set = fx_redis_service::I()->setex($key, 3, 'value');
            print '这里是业务逻辑';
        } else {
            print '返回请求次数过于频繁';
        }
    }
