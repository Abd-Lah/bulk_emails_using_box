<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class Emails extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {

        $handle = fopen(storage_path('emails.txt'), "r");
        if ($handle) {

            while (($email = fgets($handle)) !== false) {
                $result = substr($email, 0, strlen($email)-2);
                try {
                    DB::table('client_emails')->insert([
                        'email' => $result,
                        'active' => true,
                    ]);

                }catch (Exception $e){
                    continue;
                }

            }
            fclose($handle);
        }

    }
}
