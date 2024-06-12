<?php

use Illuminate\Database\Seeder;
//use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CkdCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ckd_code')->truncate();

        $data = [
            ['id' => 1,
                'ckdcode' => 'N18.1',
                'codeName' => 'CKD',
            ], [
                'id' => 2,
                'ckdcode' => 'N181',
                'codeName' => 'CKD',
            ], [
                'id' => 3,
                'ckdcode' => 'N18.2',
                'codeName' => 'CKD',
            ], [
                'id' => 4,
                'ckdcode' => 'N182',
                'codeName' => 'CKD',
            ], [
                'id' => 5,
                'ckdcode' => 'N18.3',
                'codeName' => 'CKD',
            ], [
                'id' => 6,
                'ckdcode' => 'N183',
                'codeName' => 'CKD',
            ], [
                'id' => 7,
                'ckdcode' => 'N18.4',
                'codeName' => 'CKD',
            ], [
                'id' => 8,
                'ckdcode' => 'N184',
                'codeName' => 'CKD',
            ], [
                'id' => 9,
                'ckdcode' => 'N18.5',
                'codeName' => 'CKD',
            ], [
                'id' => 10,
                'ckdcode' => 'N185',
                'codeName' => 'CKD',
            ], [
                'id' => 11,
                'ckdcode' => 'N18.6',
                'codeName' => 'ESRD',
            ],[
                'id' => 12,
                'ckdcode' => 'N186',
                'codeName' => 'ESRD',
            ]

        ];
        DB::table('ckd_code')->insert($data);
        //
    }
}
