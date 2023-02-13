<?php

namespace Database\Seeders;

use App\Models\Informations;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {
            $userData = [
                'name' => 'User' . ($i + 1),
                'email' => 'user' . ($i + 1) . '@example.com',
                'password' => bcrypt('password'),
                'provider_id' => bcrypt('password') . '123' . $i,
                'role' => 0,
                'status' => 'pending',
                'qrcode' => 'user' . ($i + 1) . '@example.com.png',
                'avatar_url' => 'https://via.placeholder.com/800x600.png/'.sprintf('%06X', mt_rand(0, 0xFFFFFF)).'?text=User' .($i + 1),
                'informations' => [
                    'gender' => ($i % 2 == 0) ? 'Male' : 'Female',
                    'date_of_birth' => '2000-01-01',
                    'address_1' => 'Address 1 ' . ($i + 1),
                    'address_2' => 'Address 2 ' . ($i + 1),
                    'title' => 'Web Developer',
                    'department' => 'Department ' . ($i + 1),
                    'shift_start' => '08:00',
                    'shift_end' => '17:00',
                    'contact_number' => '1234567890',
                    'emergency_contact_number' => '0987654321',
                ],
            ];

            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'provider_id' => $userData['provider_id'],
                'role' => $userData['role'],
                'status' => $userData['status'],
                'qrcode' => $userData['qrcode'],
                'avatar_url' => $userData['avatar_url'],
            ]);
            QrCode::format('png')->merge(public_path('td-logo.png'), .3, true)->style('round')->eye('circle')->color(41, 79, 179)->size(600)->generate(''.$userData['provider_id'].'', public_path('images/qrcodes/'.$userData['qrcode']));
            $user->informations()->create([
                'gender' => $userData['informations']['gender'],
                'date_of_birth' => $userData['informations']['date_of_birth'],
                'address_1' => $userData['informations']['address_1'],
                'address_2' => $userData['informations']['address_2'],
                'title' => $userData['informations']['title'],
                'department' => $userData['informations']['department'],
                'shift_start' => $userData['informations']['shift_start'],
                'shift_end' => $userData['informations']['shift_end'],
                'contact_number' => $userData['informations']['contact_number'],
                'emergency_contact_number' => $userData['informations']['emergency_contact_number'],
            ]);
        }
    }
}
