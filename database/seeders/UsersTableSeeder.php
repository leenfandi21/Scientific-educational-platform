<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Role;
use TCG\Voyager\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() == 0) {
            $role = Role::where('name', 'admin')->firstOrFail();

            User::create([
                'f_name'           => 'Admin',
                's_name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'phone_number'   => '0900001111',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'role_id'        => $role->id,
                'gender'       => 'male',
                'birthday'      => '1/1/1980',
                'avatar'         => 'my_avatar'
            ]);
        }
    }
}
