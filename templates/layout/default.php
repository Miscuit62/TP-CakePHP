<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mon Application</title>
        <?= $this->Html->meta('icon') ?>
        <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake']) ?>
        <?= $this->Html->script('https://code.jquery.com/jquery-3.6.0.min.js') ?>
        <?= $this->Html->script('https://code.jquery.com/ui/1.13.2/jquery-ui.min.js') ?>
        <?= $this->Html->script('https://cdn.jsdelivr.net/npm/chart.js') ?>
        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
        <style>
            body {
                display: flex;
                margin: 0;
                font-family: Arial, sans-serif;
            }
            #menu {
                width: 20%;
                background-color: #f4f4f4;
                padding: 20px;
                box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            }
            #menu h3 {
                margin-top: 0;
            }
            .menu-item {
                margin-bottom: 10px;
                padding: 10px;
                background-color: #fff;
                border: 1px solid #ddd;
                cursor: move;
            }
            .menu-item a {
                text-decoration: none;
                color: #333;
                font-weight: bold;
            }
            .menu-item a:hover {
                color: #007bff;
                text-decoration: underline;
            }
            .ui-sortable-placeholder {
                height: 40px;
                background-color: #f0f0f0;
                border: 1px dashed #ccc;
            }
            #content {
                width: 80%;
                padding: 20px;
            }
            .top-nav-title {
                position: absolute;
                left: 20%;
                top: 0;
                background-color: #007bff;
                color: #fff;
                width: 80%;
                padding: 10px 20px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .top-nav-links a {
                color: #fff;
                text-decoration: none;
                font-size: 16px;
                margin-left: 20px;
            }
            .top-nav-links a:hover {
                text-decoration: underline;
            }
            #content {
                margin-top: 60px;
                width: 80%;
                padding: 20px;
            }
        </style>
    </head>
    <body>
        <div id="menu">
            <h3>Menu</h3>
            <ul id="menu-list">
                <?php if (isset($menus)): ?>
                    <?php foreach ($menus as $menu): ?>
                        <li class="menu-item" data-id="<?= $menu->id ?>">
                            <a href="<?= $this->Url->build($menu->lien) ?>"><?= h($menu->intitule) ?></a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun menu disponible.</p>
                <?php endif; ?>
            </ul>
            <button id="save-order">Enregistrer l'ordre</button>
        </div>
        <div class="top-nav-title">
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'dashboard']) ?>">
                <span>Cake</span>PHP
            </a>
            <div class="top-nav-links">
                <a href="<?= $this->Url->build(['action' => 'editAccount']) ?>">Profil</a></li>
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>">Logout</a>
            </div>
        </div>
        <div id="content">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
        <script>
            $(document).ready(function () {
                $("#menu-list").sortable({
                    placeholder: "ui-sortable-placeholder"
                });

                $("#save-order").click(function () {
                    var order = [];
                    $("#menu-list li").each(function (index) {
                        order.push({
                            id: $(this).data("id"),
                            ordre: index + 1
                        });
                    });

                    $.ajax({
                        url: "<?= $this->Url->build(['controller' => 'Menus', 'action' => 'updateOrder']) ?>",
                        method: "POST",
                        data: {
                            order: order
                        },
                        headers: {
                            "X-CSRF-Token": <?= json_encode($this->request->getAttribute('csrfToken')) ?>
                        },
                        success: function (response) {
                            alert("L'ordre a été mis à jour !");
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.error("Erreur AJAX :", textStatus, errorThrown, jqXHR.responseText);
                            alert("Une erreur s'est produite. Détails : " + jqXHR.responseText);
                        }
                    });
                });
            });
        </script>
    </body>
</html>
