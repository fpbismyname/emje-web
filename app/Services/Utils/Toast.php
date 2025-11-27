<?php

namespace App\Services\Utils;

class Toast
{
    public static function success($message)
    {
        session()->flash('toast', [
            'message' => $message,
            'type' => 'success'
        ]);
    }
    public static function info($message)
    {
        session()->flash('toast', [
            'message' => $message,
            'type' => 'info'
        ]);
    }
    public static function error($message)
    {
        session()->flash('toast', [
            'message' => $message,
            'type' => 'error'
        ]);
    }
}