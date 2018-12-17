<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ImportLock extends Model
{
    const LOCK_ID = 1;
    //
    public static function lock()
    {
        return self::lockForUpdate()->find(self::LOCK_ID);
    }
}
