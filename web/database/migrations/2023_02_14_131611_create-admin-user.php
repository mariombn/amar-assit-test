<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $adminUserEntity = new \App\Models\User();
        $adminUserEntity->id = 1;
        $adminUserEntity->name = 'Admin';
        $adminUserEntity->email = 'admin@amar.com.br';
        $adminUserEntity->password = Hash::make('admin');
        $adminUserEntity->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\User::find(1)->delete();
    }
};
