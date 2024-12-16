<h1>Login</h1>
<?= $this->Form->create() ?>
    <div>
        <?= $this->Form->control('email', ['label' => 'Email', 'required' => true]) ?>
    </div>
    <div>
        <?= $this->Form->control('password', ['label' => 'Password', 'required' => true]) ?>
    </div>
    <div>
        <?= $this->Form->button(__('Login')) ?>
    </div>
<?= $this->Form->end() ?>
<p>
    <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'forgotPassword']) ?>">Mot de passe oublié ?</a>
</p>
