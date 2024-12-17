<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Ongkir {

    private $key = '';

    function __construct($a=[]) {
        if(isset($a['key'])) $this->key = $a['key'];
    }
    
    function getProvince() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
                CURLOPT_URL => "https://pro.rajaongkir.com/api/province",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                        "key: ".$this->key
                ),
        ));
        
        $response   = curl_exec($curl);
        $err        = curl_error($curl);
        curl_close($curl);

        $result     = [
            'status'    => [
                'code'  => '400',
                'desc'  => ''
            ],
            'results'   => []
        ];
        if ($err) {
            // echo "cURL Error #:" . $err;
        } else {
            $data       = json_decode($response, true);
            if(isset($data['rajaongkir']['status'])) {
                $result['status']['code']   = $data['rajaongkir']['status']['code'];
                $result['status']['desc']   = $data['rajaongkir']['status']['description'];
            }
            if(isset($data['rajaongkir']['results']))           $result['results']  = $data['rajaongkir']['results'];
        }
        return $result;
    }
    
    function getCity($province=0) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
                CURLOPT_URL => "https://pro.rajaongkir.com/api/city?province=$province",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                        "key: ".$this->key
                ),
        ));
        
        $response   = curl_exec($curl);
        $err        = curl_error($curl);
        curl_close($curl);
        
        $result     = [
            'status'    => [
                'code'  => '400',
                'desc'  => ''
            ],
            'results'   => []
        ];
        if ($err) {
            // echo "cURL Error #:" . $err;
        } else {
            $data       = json_decode($response, true);
            if(isset($data['rajaongkir']['status'])) {
                $result['status']['code']   = $data['rajaongkir']['status']['code'];
                $result['status']['desc']   = $data['rajaongkir']['status']['description'];
            }
            if(isset($data['rajaongkir']['results']))           $result['results']  = $data['rajaongkir']['results'];
        }
        return $result;
    }
    
    function getSubdistrict($city=0) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
                CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city=$city",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                        "key: ".$this->key
                ),
        ));
        
        $response   = curl_exec($curl);
        $err        = curl_error($curl);
        curl_close($curl);
        
        $result     = [
            'status'    => [
                'code'  => '400',
                'desc'  => ''
            ],
            'results'   => []
        ];
        if ($err) {
            // echo "cURL Error #:" . $err;
        } else {
            $data       = json_decode($response, true);
            if(isset($data['rajaongkir']['status'])) {
                $result['status']['code']   = $data['rajaongkir']['status']['code'];
                $result['status']['desc']   = $data['rajaongkir']['status']['description'];
            }
            if(isset($data['rajaongkir']['results']))           $result['results']  = $data['rajaongkir']['results'];
        }
        return $result;
    }
    
    function getCost($origin=0, $destination=0, $weight=0, $courier="") {
        $curl       = curl_init();
        curl_setopt_array($curl, array(
                CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "origin=$origin&originType=subdistrict&destination=$destination&destinationType=subdistrict&weight=$weight&courier=$courier",
                CURLOPT_HTTPHEADER => array(
                        "content-type: application/x-www-form-urlencoded",
                        "key: ".$this->key
                ),
        ));
        $response   = curl_exec($curl);
        $err        = curl_error($curl);
        curl_close($curl);
        
        $result     = [
            'status'    => [
                'code'  => '400',
                'desc'  => ''
            ],
            'results'   => []
        ];
        if ($err) {
            // echo "cURL Error #:" . $err;
        } else {
            $data       = json_decode($response, true);
            if(isset($data['rajaongkir']['status'])) {
                $result['status']['code']   = $data['rajaongkir']['status']['code'];
                $result['status']['desc']   = $data['rajaongkir']['status']['description'];
            }
            if(isset($data['rajaongkir']['results']))           $result['results']  = $data['rajaongkir']['results'];
        }
        return $result;
    }

    function tracking($waybill='',$courier='') {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "waybill=$waybill&courier=$courier",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: ".$this->key
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        
        $result     = [
            'status'    => [
                'code'  => '400',
                'desc'  => ''
            ],
            'result'    => []
        ];
        if ($err) {
            // echo "cURL Error #:" . $err;
        } else {
            $data       = json_decode($response, true);
            if(isset($data['rajaongkir']['status'])) {
                $result['status']['code']   = $data['rajaongkir']['status']['code'];
                $result['status']['desc']   = $data['rajaongkir']['status']['description'];
            }
            if(isset($data['rajaongkir']['result']))            $result['result']   = $data['rajaongkir']['result'];
        }
        return $result;
    }
    
}