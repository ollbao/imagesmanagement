<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Admin::class, 1)->create();
        //单独处理第一个用户
        $user = Admin::find(1);
        $user->username = 'admin';
        $user->nickname = '超级管理员';
        $user->is_super = 1;
        $user->save();
    }
}
