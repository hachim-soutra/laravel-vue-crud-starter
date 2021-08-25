<?php

namespace App\Helpers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Models\Admin;
use App\Models\Appointment;

function generateRandomToken() {
    return bin2hex(openssl_random_pseudo_bytes(16));
}

function createReferralCookie() {
    if (request()->has('ref') && request()->has('type')) {
        $referralId = request()->get('ref');
        $type = request()->get('type');
        $data = ['referralId' => $referralId, 'type' => $type];

        // 7 days
        return cookie('referral', json_encode($data), 10080);
    }

    return null;
}

function signUpConsumerCheckReferralExists($request, $consumer) {
    if ($request->hasCookie('referral')) {
        $referralCookie = $request->cookie('referral');
        $referralData = json_decode(decrypt($referralCookie, false), true);

        if ($referralData['type'] === 'optician') {
            $consumer->referral()->associate($consumer->optician);
        } else if ($referralData['type'] === 'admin') {
            $admin = Admin::findOrFail($referralData['referralId']);
            $consumer->referral()->associate($admin);
        }

        cookie()->forget('referral');

        $consumer->save();
    }
}

function isCurrentDateBetween($startDate, $endDate) {
    return Carbon::now()->between($startDate, $endDate);
}

function isCurrentDateGreater($date) {
    return Carbon::now()->greaterThan($date);
}

function isCurrentDateLesser($date) {
    return Carbon::now()->lessThan($date);
}


// SEND SMS HELPER
if (!function_exists('send_sms')) {

    function send_sms($text, $phone) {
        if(env("APP_ENV")=='production'){
            $key = env("SMS_API_KEY");
            try {
                $response = new Client();
                $response = $response->get('https://www.isendpro.com/cgi-bin/?keyid='.$key.'&sms='.urlencode($text).'&num='.$phone.'&emetteur=MyContACt');
                return ($response->getStatusCode());
            } catch (\Throwable $th) {
                return 500;
            }

       }else if(env("APP_ENV")=='staging'){
            $key = env("SMS_API_KEY");
            try {
                $response = new Client();
                $response = $response->get('https://www.isendpro.com/cgi-bin/?keyid='.$key.'&sms='.urlencode($text).'&num=0631670951&emetteur=MyContACt');
                return ($response->getStatusCode());
            } catch (\Throwable $th) {
                return 500;
            }
       }else{
            $key = env("SMS_API_KEY");
            try {
                $response = new Client();
                $response = $response->get('https://www.isendpro.com/cgi-bin/?keyid='.$key.'&sms='.urlencode($text).'&num=0631670951&emetteur=MyContACt');
                return ($response->getStatusCode());
            } catch (\Throwable $th) {
                return $th;
            }
       }
    }

    function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds') {
        $sets = array();
        if(strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if(strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if(strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if(strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';

        $all = '';
        $password = '';
        foreach($sets as $set)
        {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }

        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];

        $password = str_shuffle($password);

        if(!$add_dashes)
            return $password;

        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while(strlen($password) > $dash_len)
        {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }

    function  my_contact_descrypt($encrypted_data){
        try {
            return decrypt($encrypted_data);
        } catch (\Throwable $th) {
            return $encrypted_data;
        }
    }

    function compare_crypted_data($crypted, $to_compare){
        return Str::lower(my_contact_descrypt($crypted))===Str::lower($to_compare);
    }

    function  array_descrypt($array){

        $arr = [];
        foreach ($array as $encrypted_data) {
            try {
               array_push($arr, decrypt($encrypted_data));
            } catch (\Throwable $th) {
                array_push($arr, $encrypted_data);
            }
        }
        return $arr;

    }

    function unique_str($lenght) {
        $uniqueStr = Str::random($lenght);
        while(Appointment::where('token', $uniqueStr)->exists()) {
            $uniqueStr = Str::random($lenght);
        }
        return $uniqueStr;
    }
}
