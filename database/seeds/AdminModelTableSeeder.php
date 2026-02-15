<?php

use Illuminate\Database\Seeder;
use App\Model\AdminModel;
class AdminModelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new AdminModel;

        $admin->name ='Admin';
        $admin->username ='admin';
        $admin->email ='shovon58@gmail.com';
        $admin->password = bcrypt('123456');
        $admin->status = 1;
        $admin->valid = 1;
        $admin->save();
    }
}
