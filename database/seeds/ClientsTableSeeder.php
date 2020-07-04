<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients=['Ahmed','Mohamed','Abdelrhman'];
        foreach ($clients as $client) {
            \App\Client::create([
                'name'=>$client,
                'phone'=>['01060140510','01099050974'],
                'address'=>'El-Mehalla',
            ]);
        }
    }
}
