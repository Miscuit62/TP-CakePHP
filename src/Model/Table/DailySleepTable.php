<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DailySleep Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\DailySleep newEmptyEntity()
 * @method \App\Model\Entity\DailySleep newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\DailySleep> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DailySleep get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\DailySleep findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\DailySleep patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\DailySleep> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DailySleep|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\DailySleep saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\DailySleep>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DailySleep>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DailySleep>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DailySleep> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DailySleep>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DailySleep>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DailySleep>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DailySleep> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DailySleepTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('daily_sleep');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->date('sleep_date')
            ->requirePresence('sleep_date', 'create')
            ->notEmptyDate('sleep_date');

        $validator
            ->time('sleep_start')
            ->requirePresence('sleep_start', 'create')
            ->notEmptyTime('sleep_start');

        $validator
            ->time('sleep_end')
            ->requirePresence('sleep_end', 'create')
            ->notEmptyTime('sleep_end');

        $validator
            ->decimal('cycles')
            ->allowEmptyString('cycles');

        $validator
            ->boolean('nap_afternoon')
            ->allowEmptyString('nap_afternoon');

        $validator
            ->boolean('nap_evening')
            ->allowEmptyString('nap_evening');

        $validator
            ->boolean('sport')
            ->allowEmptyString('sport');

        $validator
            ->integer('morning_score')
            ->requirePresence('morning_score', 'create')
            ->allowEmptyString('morning_score');

        $validator
            ->scalar('comment')
            ->allowEmptyString('comment');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
