<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DailySleep $dailySleep
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Sleep Record'), ['action' => 'edit', $dailySleep->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(
                __('Delete Sleep Record'),
                ['action' => 'delete', $dailySleep->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $dailySleep->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Sleep Records'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Sleep Record'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="sleep view content">
            <h3><?= h($dailySleep->sleep_date) ?></h3>
            <table>
                <tr>
                    <th><?= __('Date de sommeil') ?></th>
                    <td><?= h($dailySleep->sleep_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Heure de coucher') ?></th>
                    <td><?= h($dailySleep->sleep_start) ?></td>
                </tr>
                <tr>
                    <th><?= __('Heure de lever') ?></th>
                    <td><?= h($dailySleep->sleep_end) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nombre de cycles') ?></th>
                    <td><?= $this->Number->format($dailySleep->cycles) ?></td>
                </tr>
                <tr>
                    <th><?= __('Score du matin') ?></th>
                    <td><?= $this->Number->format($dailySleep->morning_score) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sieste après-midi') ?></th>
                    <td><?= $dailySleep->sieste_apres_midi ? __('✔') : __('✘') ?></td>
                </tr>
                <tr>
                    <th><?= __('Sieste soir') ?></th>
                    <td><?= $dailySleep->sieste_soir ? __('✔') : __('✘') ?></td>
                </tr>
                <tr>
                    <th><?= __('Pratique de sport') ?></th>
                    <td><?= $dailySleep->sport ? __('✔') : __('✘') ?></td>
                </tr>
                <tr>
                    <th><?= __('Commentaire') ?></th>
                    <td><?= h($dailySleep->comment) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($dailySleep->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($dailySleep->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
