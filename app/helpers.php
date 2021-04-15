<?php

function get_user_login($load_rl_pegawai = false)
{
    $user_login = auth()->user();

    // if ($load_rl_pegawai) {
    //     $seconds = 60*60*24*7; // seminggu
    //     $rl_pegawai = cache()->remember('intranet_m_pegawai_'.$user_login->npp, $seconds, function () use ($user_login) {
    //         return \App\Models\MPegawai::npp($user_login->npp)->first();
    //     });
    //     $user_login->rl_pegawai = $rl_pegawai;
    // }

    return $user_login;
}

function get_user_ip_addr()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }
    return $ipaddress;
}

function random_password($length = 6, $difficulty = 'medium')
{
    if ($difficulty == 'easy') {
        $alphabet = '1234567890';
    } elseif ($difficulty == 'medium') {
        $alphabet = 'abcdefghijklmnopqrstuvwxyz1234567890';
    } elseif ($difficulty == 'hard') {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    }

    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
