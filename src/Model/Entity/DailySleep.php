<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DailySleep Entity
 *
 * @property int $id
 * @property int $user_id
 * @property \Cake\I18n\Date $sleep_date
 * @property \Cake\I18n\Time $sleep_start
 * @property \Cake\I18n\Time $sleep_end
 * @property string|null $cycles
 * @property bool|null $nap_afternoon
 * @property bool|null $nap_evening
 * @property bool|null $sport
 * @property int|null $morning_score
 * @property string|null $comment
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 */
class DailySleep extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'user_id' => true,
        'sleep_date' => true,
        'sleep_start' => true,
        'sleep_end' => true,
        'cycles' => true,
        'nap_afternoon' => true,
        'nap_evening' => true,
        'sport' => true,
        'morning_score' => true,
        'comment' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
    ];
}
