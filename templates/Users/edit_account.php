<h1>Modifier mes informations</h1>

<?= $this->Form->create($user) ?>
    <div>
        <?= $this->Form->control('first_name', ['label' => 'Prénom', 'required' => true]) ?>
    </div>
    <div>
        <?= $this->Form->control('last_name', ['label' => 'Nom', 'required' => true]) ?>
    </div>
    <div>
        <?= $this->Form->control('email', ['label' => 'Email', 'required' => true]) ?>
    </div>
    <hr>
    <h3>Changer le mot de passe</h3>
    <div>
        <?= $this->Form->control('password', [
            'label' => 'Nouveau mot de passe',
            'type' => 'password',
            'required' => false
        ]) ?>
    </div>
    <div>
        <?= $this->Form->control('password_confirm', [
            'label' => 'Confirmez le mot de passe',
            'type' => 'password',
            'required' => false
        ]) ?>
    </div>
    <div>
        <?= $this->Form->button(__('Mettre à jour')) ?>
    </div>
<?= $this->Form->end() ?>
