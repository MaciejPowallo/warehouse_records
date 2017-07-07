<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Maciej';
        $user->surname = 'Powallo';       
        $user->email = 'admin@wr.pl';       
        $user->password = Hash::make('password123');       
        $user->telephone = '+48 669364258';       
        $user->function = 'Administrator';          
        $user->save();
        $user->roles()->attach(1);
        $user->roles()->attach(2);
        $user->roles()->attach(3);
        $user->roles()->attach(4);

        $user = new User();
        $user->name = 'Karol';
        $user->surname = 'Nowak';       
        $user->email = 'k.nowak@wr.pl';       
        $user->password = Hash::make('password123');       
        $user->telephone = '+48 457236951';       
        $user->function = 'Magazynier';          
        $user->save();
        $user->roles()->attach(2); 
        $user->roles()->attach(3);
        $user->roles()->attach(4);

        $user = new User();
        $user->name = 'Jan';
        $user->surname = 'Kowalski';       
        $user->email = 'j.kowalski@wr.pl';       
        $user->password = Hash::make('password123');       
        $user->telephone = '+48 123456789';       
        $user->function = 'Kierownik';          
        $user->save();
        $user->roles()->attach(3);
        $user->roles()->attach(4);

        $user = new User();
        $user->name = 'Stefan';
        $user->surname = 'Batory';       
        $user->email = 's.batory@wr.pl';       
        $user->password = Hash::make('password123');       
        $user->telephone = '+48 669364258';       
        $user->function = 'Księgowy';          
        $user->save();
        $user->roles()->attach(4);


        $faker = Faker::create('pl_PL');
        foreach (range(1,50) as $user) {
            $surname = $faker->lastNameMale;
            User::create([
                'name'              =>  $faker->firstNameMale,
                'surname'           =>  $surname,
                'email'             =>  $faker->bothify('?.').$surname.$faker->bothify('@wr.pl'),
                'password'          =>  Hash::make('password123'),    
                'telephone'         =>  $faker->phoneNumber,
                'function'          =>  $faker->randomElement($array = array('Administrator','Magazynier','Kierownik')),
            ]);
        }

        foreach (range(1,50) as $user) {
            $surname = $faker->lastNameFemale;
            User::create([
                'name'              =>  $faker->firstNameFemale,
                'surname'           =>  $surname,
                'email'             =>  $faker->bothify('?.').$surname.$faker->bothify('@wr.pl'),
                'password'          =>  Hash::make('password123'),    
                'telephone'         =>  $faker->phoneNumber,
                'function'          =>  $faker->randomElement($array = array('Administrator','Magazynier','Kierownik')),
            ]);
        }
    }
}