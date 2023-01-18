<?php

namespace Database\Seeders;

use App\Models\MailSubscription;
use Illuminate\Database\Seeder;

class MailSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mail = MailSubscription::factory(100)->create();
        $mail->random(rand(15, 20))->each(function ($item, $key) {
            $item->delete();
        });
    }
}
