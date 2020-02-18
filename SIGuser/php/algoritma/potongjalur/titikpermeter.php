<?php
class titikkoordinat
{
    function jarak($lat1, $lng1, $lat2, $lng2)
    {
        $rad = M_PI / 180;
        $jarak=acos(sin($lat2*$rad) * sin($lat1*$rad) + cos($lat2*$rad) * cos($lat1*$rad) * cos($lng2*$rad - $lng1*$rad)) * 6371;// Kilometers
        return $jarak*1000;
    }

    function vertek($lat, $lng, $lat2, $lng2)
    {
        $radius = 6378100; // radius of earth in meters
        $latDist = $lat - $lat2;
        $lngDist = $lng - $lng2;
        $latDistRad = deg2rad($latDist);
        $lngDistRad = deg2rad($lngDist);
        $sinLatD = sin($latDistRad);
        $sinLngD = sin($lngDistRad);
        $cosLat1 = cos(deg2rad($lat));
        $cosLat2 = cos(deg2rad($lat2));
        $a = ($sinLatD/2)*($sinLatD/2) + $cosLat1*$cosLat2*($sinLngD/2)*($sinLngD/2);
        if($a<0) $a = -1*$a;
        $c = 2*atan2(sqrt($a), sqrt(1-$a));
        return $distance = $radius*$c;
    }

    function titikm($lat,$lng,$lat2,$lng2)
    {
        $koor=array();
        $latx=$lat;
        $lngx=$lng;
        $latxx=$lat2;
        $lngxx=$lng2;

        $panjangtitik=round($this->jarak($lat,$lng,$lat2,$lng2),0);
        //perpindahan selama 1meter
        
        $latlng=array(0 => $latx, 1=>$lngx);
        array_push($koor,$latlng);
        //$txt=$txtt='['.$latx.','.$lngx.'],';

        for ($i=1; $i<=$panjangtitik ; $i++) 
        { 
            $ratio=1/$this->vertek($lat, $lng, $lat2, $lng2);
            $lat= $lat + (($lat2 - $lat) * $ratio);
            $lng = $lng + (($lng2 - $lng) * $ratio);
            $latlng=array(0 => $lat, 1=>$lng);
            array_push($koor,$latlng);
            
            // if($i<$panjangtitik )
            //     $txtt='['.$lat.','.$lng.'],';
            // else
            //     $txtt='['.$lat.','.$lng.']';
            //$txtt='['.$lat.','.$lng.'],';
            //$txt=$txt.$txtt;
        }

        //echo $txt;
        // $hasiltxt=$txt.$txtt='['.$latxx.','.$lngxx.']';
        // return $hasiltxt;

        //echo $hasiltxt;

        $latlng=array(0 => $latxx, 1=>$lngxx);
        array_push($koor,$latlng);
        //echo "<pre>"; print_r($koor);

        //echo json_encode($koor);
        return $koor;
    }
}
// $titikk=new titikkoordinat;
// $titikk->titikm(-0.8750326503585448,119.83236685395241,-0.8750688559573624,119.83206108212471);

?>