<h1>Mot de passe oublié</h1>

<p>Veuillez saisir votre adresse e-mail pour générer un nouveau mot de passe.</p>

<?= $this->Form->create() ?>
    <div>
        <?= $this->Form->control('email', ['label' => 'Email', 'required' => true]) ?>
    </div>
    <div>
        <?= $this->Form->button(__('Générer un mot de passe')) ?>
    </div>
<?= $this->Form->end() ?>

<?php if (isset($password)): ?>
    <h3>Votre nouveau mot de passe :</h3>
    <p><strong><?= h($password) ?></strong></p>
    <p>Veuillez le noter ou le conserver en lieu sûr.</p>
<?php endif; ?>
