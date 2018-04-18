<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 10)->create();
        //单独处理第一个用户
        $user = User::find(1);
        $user->name = 'ollbao';
        $user->email = 'zhong1714@qq.com';
        $user->password = bcrypt('bb5211714');
        $user->save();
    }
}
