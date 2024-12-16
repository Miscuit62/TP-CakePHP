<?php
declare(strict_types=1);

use Migrations\BaseSeed;

/**
 * DailySleepSeed seed.
 */
class DailySleepSeedSeed extends BaseSeed
{
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'sleep_date' => '2024-12-01',
                'sleep_start' => '22:00:00',
                'sleep_end' => '06:30:00',
                'cycles' => 5.0,
                'nap_afternoon' => true,
                'nap_evening' => false,
                'sport' => true,
                'morning_score' => 8,
                'comment' => 'Bonne nuit',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            // Ajoutez d'autres lignes ici
        ];

        $table = $this->table('daily_sleep');
        $table->insert($data)->save();
    }
}
