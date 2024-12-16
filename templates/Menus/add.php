<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Menu $menu
 */
?>
<div class="row">
    <div class="column column-80">
        <div class="menus form content">
            <?= $this->Form->create($menu) ?>
            <fieldset>
                <legend><?= __('Add Menu') ?></legend>
                <?php
                    echo $this->Form->control('ordre');
                    echo $this->Form->control('intitule');
                    echo $this->Form->control('lien');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
