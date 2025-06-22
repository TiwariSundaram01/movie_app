<?php

use Illuminate\Support\Facades\Auth;

function userData()
{
    return session()->get('userData' , []);
}

function isAdmin()
{
    $userData = session('userData');

    if ($userData && isset($userData['is_admin']) && $userData['is_admin'] == 1) {
        return true;
    }

    return false;
}


?>