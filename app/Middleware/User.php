<?php

namespace App\Middleware;

class User {
    public function handle() {
        if (1 !== 1) {
            die('test');
        }
    }
}