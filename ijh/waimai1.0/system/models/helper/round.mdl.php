<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author @shzhrui<Anhuike@gmail.com>
 * $Id: database.mdl.php 9343 2015-03-24 07:07:00Z youyi $
 */

class Mdl_Helper_Round extends Model
{


    /**
        *计算某个经纬度的周围某段距离的正方形的四个点
        *
        *@param lng float 经度
        *@param lat float 纬度
        *@param distance float 该点所在圆的半径，该圆与此正方形内切，默认值为0.5千米
        *@return array 正方形的四个点的经纬度坐标
        */

        public function returnSquarePoint($lng, $lat, $distance = 10)
        {
            define(EARTH_RADIUS, 6371);//地球半径，平均半径为6371km
            $dlng =  2 * asin(sin($distance / (2 * EARTH_RADIUS)) / cos(deg2rad($lat)));
            $dlng = rad2deg($dlng);
            $dlat = $distance/EARTH_RADIUS;
            $dlat = rad2deg($dlat);
            return array(
                'left-top'=>array('lat'=>$lat + $dlat,'lng'=>$lng-$dlng),
                'right-top'=>array('lat'=>$lat + $dlat, 'lng'=>$lng + $dlng),
                'left-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng - $dlng),
                'right-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng + $dlng)
            );
        }


    public function getdistance($lng1, $lat1, $lng2, $lat2)
    {  //计算经纬度距离
        //将角度转为狐度
        $radLat1=deg2rad($lat1);//deg2rad()函数将角度转换为弧度
        $radLat2=deg2rad($lat2);
        $radLng1=deg2rad($lng1);
        $radLng2=deg2rad($lng2);
        $a=$radLat1-$radLat2;
        $b=$radLng1-$radLng2;
        $s=2*asin(sqrt(pow(sin($a/2),2)+cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)))*6378.137*1000;
        return K::M('helper/format')->juli($s);
    }

    public function getdistances($lng1,$lat1,$lng2,$lat2){  //计算经纬度距离 返回米数
        //将角度转为狐度
        $radLat1=deg2rad($lat1);//deg2rad()函数将角度转换为弧度
        $radLat2=deg2rad($lat2);
        $radLng1=deg2rad($lng1);
        $radLng2=deg2rad($lng2);
        $a=$radLat1-$radLat2;
        $b=$radLng1-$radLng2;
        $s=2*asin(sqrt(pow(sin($a/2),2)+cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)))*6378.137*1000;
        return round($s,2);
    }
}
