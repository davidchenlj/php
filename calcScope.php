
    /**
     * 根据经纬度和半径计算出范围 纬度 经度 50公里内
     * calcScope(22.544436, 114.103897， 50000);
     * @param string $lng 经度
     * @param String $lat 纬度
     * @param float $radius 半径
     * @return Array 范围数组
     */
    public function calcScope($lng, $lat, $radius=500000)
    {
        $degree = (24901 * 1609) / 360.0;
        $dpmLat = 1 / $degree;

        $radiusLat = $dpmLat * $radius;
        $minLat    = $lat - $radiusLat;
        $maxLat    = $lat + $radiusLat;

        $mpdLng    = $degree * cos($lat * (PI / 180));
        $dpmLng    = 1 / $mpdLng;
        $radiusLng = $dpmLng * $radius;
        $minLng    = $lng - $radiusLng;
        $maxLng    = $lng + $radiusLng;

        /** 返回范围数组 */
        $scope = array(
            'minLat' => $minLat, // 最小经度
            'maxLat' => $maxLat, // 最小纬度
            'minLng' => $minLng, // 最小经度
            'maxLng' => $maxLng, // 最大经度
        );
        return $scope;
    }
