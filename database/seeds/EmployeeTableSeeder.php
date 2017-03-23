<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon as Carbon;
use App\Employee;

class EmployeeTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('employees')->delete();

        array_map(function($e) { return Employee::create($e); }, [
            [
                'id' => '1',
                'name' => 'Rick Sanchez',
                'email' => 'rick@email.com',
                'date_of_birth' => Carbon::now(),
                'address1' => '123 Main st',
                'city' => 'Santa Monica',
                'state' => 'CA',
                'postal_code' => '90403',
                'country' => 'US',
            ],
            [
                'id' => '2',
                'name' => 'Morty Smith',
                'email' => 'morty@email.com',
                'date_of_birth' => Carbon::now(),
                'address1' => '123 Main st',
                'city' => 'Santa Monica',
                'state' => 'CA',
                'postal_code' => '90403',
                'country' => 'US',
            ],
            [
                'id' => '3',
                'name' => 'Beth Smith',
                'email' => 'beth@email.com',
                'date_of_birth' => Carbon::now(),
                'address1' => '123 Main st',
                'city' => 'Santa Monica',
                'state' => 'CA',
                'postal_code' => '90403',
                'country' => 'US',
            ],
            [
                'id' => '4',
                'name' => 'Jerry Smith',
                'email' => 'jerry@email.com',
                'date_of_birth' => Carbon::now(),
                'address1' => '123 Main st',
                'city' => 'Santa Monica',
                'state' => 'CA',
                'postal_code' => '90403',
                'country' => 'US',
            ],
        ]);
    }
}
