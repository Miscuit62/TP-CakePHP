<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\DailySleep> $dailySleepRecords
 */
?>
<div class="sleep index content">
    <?= $this->Html->link(__('New Sleep Record'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Sleep Records') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('sleep_date', 'Date') ?></th>
                    <th><?= $this->Paginator->sort('sleep_start', 'Heure de coucher') ?></th>
                    <th><?= $this->Paginator->sort('sleep_end', 'Heure de lever') ?></th>
                    <th><?= $this->Paginator->sort('cycles', 'Cycles') ?></th>
                    <th><?= $this->Paginator->sort('morning_score', 'Score Matin') ?></th>
                    <th><?= __('Sieste AM') ?></th>
                    <th><?= __('Sieste PM') ?></th>
                    <th><?= __('Sport') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dailySleepRecords as $dailySleep): ?>
                <tr>
                    <td><?= $this->Number->format($dailySleep->id) ?></td>
                    <td><?= h($dailySleep->sleep_date) ?></td>
                    <td><?= h($dailySleep->sleep_start) ?></td>
                    <td><?= h($dailySleep->sleep_end) ?></td>
                    <td><?= $this->Number->format($dailySleep->cycles) ?></td>
                    <td><?= $this->Number->format($dailySleep->morning_score) ?></td>
                    <td><?= $dailySleep->sieste_apres_midi ? __('✔') : __('✘') ?></td>
                    <td><?= $dailySleep->sieste_soir ? __('✔') : __('✘') ?></td>
                    <td><?= $dailySleep->sport ? __('✔') : __('✘') ?></td>
                    <td><?= h($dailySleep->created) ?></td>
                    <td><?= h($dailySleep->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $dailySleep->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $dailySleep->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $dailySleep->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dailySleep->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
