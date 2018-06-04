<?php

use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('currencies')->insert([
      ["code" => "USD","name" => "United States Dollar","symbol" => '$', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ["code" => "EUR","name" => "Euro","symbol" => "€", 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
    ]);
  }
}
