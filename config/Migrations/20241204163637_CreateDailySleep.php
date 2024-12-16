<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateDailySleep extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('daily_sleep');
        $table
            ->addColumn('user_id', 'integer', ['null' => false])
            ->addColumn('sleep_date', 'date', ['null' => false])
            ->addColumn('sleep_start', 'time', ['null' => false])
            ->addColumn('sleep_end', 'time', ['null' => false])
            ->addColumn('cycles', 'decimal', ['precision' => 3, 'scale' => 1, 'default' => 0, 'null' => false])
            ->addColumn('nap_afternoon', 'boolean', ['default' => false])
            ->addColumn('nap_evening', 'boolean', ['default' => false])
            ->addColumn('sport', 'boolean', ['default' => false])
            ->addColumn('morning_score', 'integer', ['null' => true])
            ->addColumn('comment', 'text', ['null' => true])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }
}
