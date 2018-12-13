<?php
/* @var $this \yii\web\View */

?>


<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= $fullName ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        
        <?= themes\adminlte\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => 'Команды', 'icon' => 'user-secret', 'url' => ['team/index']],
                    ['label' => 'GRUD', 'icon' => 'file-image-o', 'items' => [
                        ['label' => 'Роли', 'icon' => 'user-secret', 'url' => ['crud/role/index']],
                        ['label' => 'Пользователи', 'icon' => 'users', 'url' => ['crud/user/index']],
                        ['label' => 'Задачи', 'icon' => 'tasks', 'url' => ['crud/task/index']],
                        ['label' => 'Изображения', 'icon' => 'file-image-o', 'url' => ['crud/image/index']],
                        ['label' => 'Сообщения чата', 'icon' => 'file-image-o', 'url' => ['crud/chat-messages/index']],
                        ['label' => 'Статусы проекта', 'icon' => 'file-image-o', 'url' => ['crud/project-statuses/index']],
                        ['label' => 'Статусы задач', 'icon' => 'file-image-o', 'url' => ['crud/task-statuses/index']],
                        ['label' => 'Проекты', 'url' => ['crud/project/index']],
                        ['label' => 'Команды', 'url' => ['crud/team/index']],
                        ['label' => 'Пользователь - команда', 'url' => ['crud/team-user/index']],
                    ]],
                    ['label' => 'Телеграм', 'icon' => 'file-image-o', 'items' => [
                        ['label' => 'GRUD', 'icon' => 'file-image-o', 'items' => [
                            ['label' => 'Комманды', 'url' => ['crud/telegram-commands/index']],
                            ['label' => 'Подписки', 'url' => ['crud/subscription/index']],
                            ['label' => 'Чаты пользователей', 'url' => ['crud/user-chat/index']],
                        ]],
                    ]],
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                ],
            ]
        ) ?>

    </section>

</aside>
