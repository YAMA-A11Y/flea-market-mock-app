<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Like;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'name' => '腕時計',
                'price' => '15000',
                'brand' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ時計',
                'condition' => '良好',
                'image_path' => 'items/Armani+Mens+Clock.jpg',
            ],
            [
                'name' => 'HDD',
                'price' => '5000',
                'brand' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'condition' => '目立った傷や汚れなし',
                'image_path' => 'items/HDD+Hard+Disk.jpg',
            ],
            [
                'name' => '玉ねぎ3束',
                'price' => '300',
                'brand' => null,
                'description' => '新鮮な玉ねぎ3束のセット',
                'condition' => 'やや傷や汚れあり',
                'image_path' => 'items/iLoveIMG+d.jpg',
            ],
            [
                'name' => '革靴',
                'price' => '4000',
                'brand' => null,
                'description' => 'クラシックなデザインの革靴',
                'condition' => '状態が悪い',
                'image_path' => 'items/Leather+Shoes+Product+Photo.jpg',
            ],
            [
                'name' => 'ノートPC',
                'price' => '45000',
                'brand' => null,
                'description' => '高性能なノートパソコン',
                'condition' => '良好',
                'image_path' => 'items/Living+Room+Laptop.jpg',
            ],
            [
                'name' => 'マイク',
                'price' => '8000',
                'brand' => null,
                'description' => '高音質のレコーディング用マイク',
                'condition' => '目立った傷や汚れなし',
                'image_path' => 'items/Music+Mic+4632231.jpg',
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => '3500',
                'brand' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'condition' => 'やや傷や汚れあり',
                'image_path' => 'items/Purse+fashion+pocket.jpg',
            ],
            [
                'name' => 'タンブラー',
                'price' => '500',
                'brand' => null,
                'description' => '使いやすいタンブラー',
                'condition' => '状態が悪い',
                'image_path' => 'items/Tumbler+souvenir.jpg',
            ],
            [
                'name' => 'コーヒーミル',
                'price' => '4000',
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'condition' => '良好',
                'image_path' => 'items/Waitress+with+Coffee+Grinder.jpg',
            ],
            [
                'name' => 'メイクセット',
                'price' => '2500',
                'brand' => null,
                'description' => '便利なメイクアップセット',
                'condition' => '目立った傷や汚れなし',
                'image_path' => 'items/外出メイクアップセット.jpg',
            ],
        ];

        $likedCount = 0;

        foreach ($items as $i => $data) {

            $ownerId = ($i % 2 === 0) ? 1 : 2;

            $item =Item::create(array_merge($data, [
                'user_id' => $ownerId,
                'is_sold' => ($i === 0),
            ]));

            if ($ownerId === 1 && $likedCount < 3) {
                Like::create([
                    'user_id' => 2,
                    'item_id' => $item->id,
                ]);
                $likedCount++;
            }
        }
    }
}
