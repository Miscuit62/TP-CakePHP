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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $dailySleep->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $dailySleep->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Sleep Records'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="sleep form content">
            <?= $this->Form->create($dailySleep) ?>
            <fieldset>
                <legend><?= __('Edit Sleep Record') ?></legend>
                <?php
                    echo $this->Form->control('sleep_start', ['type' => 'time', 'label' => 'Heure de coucher']);
                    echo $this->Form->control('sleep_end', ['type' => 'time', 'label' => 'Heure de lever']);
                    echo $this->Form->control('forme_reveil', [
                        'type' => 'number',
                        'label' => 'Score du matin (0-10)',
                        'min' => 0,
                        'max' => 10
                    ]);
                    echo $this->Form->control('comment', ['type' => 'textarea', 'label' => 'Commentaire']);
                    echo $this->Form->control('sieste_apres_midi', [
                        'type' => 'checkbox',
                        'label' => 'Sieste après-midi'
                    ]);
                    echo $this->Form->control('sieste_soir', [
                        'type' => 'checkbox',
                        'label' => 'Sieste soir'
                    ]);
                    echo $this->Form->control('sport', [
                        'type' => 'checkbox',
                        'label' => 'Pratique de sport'
                    ]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
