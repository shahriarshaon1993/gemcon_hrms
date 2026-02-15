<?php

use Illuminate\Database\Seeder;
use App\Model\UserModel;
class UserModelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new UserModel;

        $admin->name ='User';
        $admin->username ='user';
        $admin->email ='shovon58@gmail.com';
        $admin->password = bcrypt('123456');
        $admin->status = 1;
        $admin->valid = 1;
        $admin->save();
    }
}
