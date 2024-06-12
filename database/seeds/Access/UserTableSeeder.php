<?php

use Carbon\Carbon as Carbon;
use Database\DisableForeignKeys;
use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        $this->truncate(config('access.users_table'));

//        //Add the master administrator, user id of 1
//        $users = [
//            [
//                'first_name'        => 'Super',
//                'last_name'         => 'Admin',
//                'email'             => 'admin@nephrolytix.com',
//                'password'          => bcrypt('123456'),
//                'confirmation_code' => md5(uniqid(mt_rand(), true)),
//                'confirmed'         => true,
//                'created_by'        => 1,
//                'updated_by'        => null,
//                'created_at'        => Carbon::now(),
//                'updated_at'        => Carbon::now(),
//                'deleted_at'        => null,
//            ],
//        ];

//        DB::table(config('access.users_table'))->insert($users);

        $this->enableForeignKeys();
    }
}
