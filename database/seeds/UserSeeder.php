<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('users')->insert([
      ['name' => 'admin', 'email' => 'admin@laravel.local', 'password' => '$2y$10$w6SCKcX/0vh1nEvqKXmpyeB3W3wZY7Q.9szCgrkVfSvSjoKxxO46e', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
    ]);
  }
}
