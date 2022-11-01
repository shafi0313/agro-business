<?php

use Carbon\Carbon;
use App\Models\PurchaseInvoice;

if (!function_exists('BdDate')) {
    function BdDate($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }
}

if (!function_exists('user')) {
    function user()
    {
        return auth()->user();
    }
}

if (!function_exists('imagePath')) {
    function imagePath($folder,$image)
    {
        return asset('uploads/images/'.$folder.'/'.$image);
    }
}

if (!function_exists('transaction_id')) {
    function transaction_id($src = '', $length = 12)
    {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($length / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
        } else {
            throw new \Exception("no cryptographically secure random function available");
        }
        if ($src != '') {
            return strtoupper($src.'_'.substr(bin2hex($bytes), 0, $length));
        }
        return strtoupper(substr(bin2hex($bytes), 0, $length));
    }
}

if (!function_exists('readableSize')) {
    function readableSize($bytes)
    {
        $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}

if (!function_exists('invType')) {
    function invType($invoice)
    {
        // return match ($invoice) {
        //     '0' => 'Previous',
        //     '1' => 'Cash Sales',
        //     '2' => 'Return Cash Sales',
        //     '3' => 'Credit Sales',
        //     '4' => 'Return Credit Sales',
        //     '5' => 'Sample',
        //     '7' => 'Bulk Sales',
        //     '16' => 'Bulk Ca. Sales',
        //     '17' => 'Bulk Ca. Return',
        //     '18' => 'Bulk Cr. Sales',
        //     '19' => 'Bulk Cr. Return',
        //     '25' => 'Collection',
        //     default => 'Error'
        // };
        switch($invoice){
            case 0;
                $invType = 'Previous';
                break;
            case 1;
                $invType = 'Cash Sales';
                break;
            case 2;
                $invType = 'Return Cash Sales';
                break;
            case 3;
                $invType = 'Credit Sales';
                break;
            case 4;
                $invType = 'Return Credit Sales';
                break;
            case 5;
                $invType = 'Sample';
                break;
            case 7;
                $invType = 'Bulk Sales';
                break;
            case 16;
                $invType = 'Bulk Ca. Sales';
                break;
            case 18;
                $invType = 'Bulk Cr. Sales';
                break;
            case 19;
                $invType = 'Bulk Cr. Return';
                break;
            case 25;
                $invType = 'Collection';
                break;
            default:
                $invType = 'Error';
        }
        return $invType;
    }
}

if (!function_exists('sms')) {
    function sms($phone, $msg)
    {
        $token = env('SMS_API');
        $url = "http://api.greenweb.com.bd/api.php";
        $data= array(
            'to'=>"$phone",
            'message'=>"$msg",
            'token'=>"$token"
        ); // Add parameters in key value
        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        //Result
        // echo $smsresult;
        //Error Display
        // echo curl_error($ch);
    }
}

if (!function_exists('activeSubNav')) {
    function activeSubNav($route)
    {
        if (is_array($route)) {
            $rt = '';
            foreach ($route as $rut) {
                $rt .= request()->routeIs($rut) || '';
            }
            return $rt ? ' activeSub ' : '';
        }
        return request()->routeIs($route) ? ' activeSub ' : '';
    }
}

if (!function_exists('activeNav')) {
    function activeNav($route)
    {
        if (is_array($route)) {
            $rt = '';
            foreach ($route as $rut) {
                $rt .= request()->routeIs($rut) || '';
            }
            return $rt ? ' active ' : '';
        }
        return request()->routeIs($route) ? ' active ' : '';
    }
}

if (!function_exists('openNav')) {
    function openNav(array $routes)
    {
        $rt = '';
        foreach ($routes as $route) {
            $rt .= request()->routeIs($route) || '';
        }
        return $rt ? ' show ' : '';
    }
}




