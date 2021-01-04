<?php

namespace App\Services\Common;

class IpToAreaServices
{

    /**
     * 取得 IP 地區資訊
     *
     * @param  string  $ip
     * @return string
     */
    public function ipToArea($ip)
    {
        try {
            $ipDetails = GeoIP($ip);
            $area = $ipDetails['continent'] . ',' . $ipDetails['country'] . ',' . $ipDetails['city'];
        } catch (\Exception $e) {
            $area = '';
        }

        return $area;
    }
}
