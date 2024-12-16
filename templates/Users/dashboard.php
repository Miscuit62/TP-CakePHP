<style>
    .green {
        color: green;
        font-weight: bold;
    }

    .red {
        color: red;
        font-weight: bold;
    }

    .button-group {
        display: inline-flex;
        gap: 10px;
    }
</style>
<h1>Suivi du Sommeil</h1>
<?= $this->Form->create() ?>
<div class="input-group">
    <label>Heure de coucher :</label>
    <?= $this->Form->time('sleep_start', ['value' => $todaySleepData->sleep_start ?? null]) ?>
</div>
<div class="input-group">
    <label>Heure de lever :</label>
    <?= $this->Form->time('sleep_end', ['value' => $todaySleepData->sleep_end ?? null]) ?>
</div>
<div class="input-group">
    <label>Forme au réveil (0-10) :</label>
    <?= $this->Form->select('forme_reveil', range(0, 10), ['value' => $todaySleepData->forme_reveil ?? null]) ?>
</div>
<div class="input-group">
    <label>Commentaire :</label>
    <?= $this->Form->textarea('comment', ['value' => $todaySleepData->comment ?? null]) ?>
</div>
<div class="input-group">
    <?= $this->Form->checkbox('sieste_apres_midi', ['checked' => $todaySleepData->sieste_apres_midi ?? false]) ?> Sieste après-midi
    <?= $this->Form->checkbox('sieste_soir', ['checked' => $todaySleepData->sieste_soir ?? false]) ?> Sieste soir
    <?= $this->Form->checkbox('sport', ['checked' => $todaySleepData->sport ?? false]) ?> Sport
</div>
<div class="button-group">
    <?= $this->Form->button('Valider', ['type' => 'submit']) ?>
    <?= $this->Html->link('Résumé hebdomadaire', ['controller' => 'Sleep', 'action' => 'weeklySummary'], ['class' => 'button']) ?>
  </div>
<?= $this->Form->end() ?>
<h2>Résultats</h2>
<?php if (!is_null($cycles)): ?>
    <p>Nombre de cycles : 
        <strong class="<?= $cycles >= 5 ? 'green' : 'red' ?>">
            <?= h($cycles) ?>
        </strong>
    </p>
    <p>Indicateur : 
        <strong class="<?= $cycles >= 5 ? 'green' : 'red' ?>">
            <?= h($indicator) ?>
        </strong>
    </p>
<?php else: ?>
    <p>Aucun résultat disponible pour l'instant.</p>
<?php endif; ?>
