<?php

namespace App\Database;

use Illuminate\Support\Facades\DB;

class Database
{
    public static function connect()
    {
        try {
            return DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Không thể kết nối tới database: " . $e->getMessage());
        }
    }
}
