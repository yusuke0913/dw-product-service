<?php

use Illuminate\Database\Seeder;
use App\Model\ImportLock;

class ImportLockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $importLock = new ImportLock();
        $importLock->id = ImportLock::LOCK_ID;
        $importLock->save();
    }
}
