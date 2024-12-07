<?php

namespace Database\Seeders;

use App\Models\Community;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $communities = [
            ['name' => 'Kitap Severler', 'description' => 'Kitap okuma alışkanlığı olanların topluluğu.'],
            ['name' => 'Doğa Yürüyüşçüleri', 'description' => 'Doğa ile iç içe yürüyüş sevenler.'],
            ['name' => 'Teknoloji Meraklıları', 'description' => 'Teknoloji hakkında tartışma ve paylaşım platformu.'],
            ['name' => 'Müzik Tutkunları', 'description' => 'Müzik hakkında konuşmak isteyenlerin buluşma noktası.'],
            ['name' => 'Fotoğrafçılık', 'description' => 'Fotoğrafçılık hakkında bilgi paylaşımı ve rehberlik.'],
        ];

        foreach ($communities as $community) {
            Community::create($community);
        }
    }
}
