<?php

namespace app\Templates;

use app\Clases\Auth;
use app\Clases\Request;
use app\Clases\Validator;
use app\Models\Setting;

abstract class Template
{
    protected $titel;
    protected $setting;
    protected $request;
    protected $validator;
    public function __construct()
    {
        $this->request = new Request();
        $this->validator = new Validator($this->request);
        $settingModel = new Setting();
        $this->setting = $settingModel->getFirstData();
    }

    protected function getHead()
    {
?>

        <head>
            <meta charset="UTF-8">
            <meta name="desception" content="<?= $this->setting->getDesception() ?>">
            <meta name="keywords" content="<?= $this->setting->getKeywords() ?>">
            <meta name="authors" content="<?= $this->setting->getAuthors() ?>">

            <title><?= $this->titel ?></title>
            <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
        </head>
    <?php
    }


    protected function getAdminHead()
    {
    ?>

        <head>
            <title><?= $this->titel ?></title>
            <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
            <link rel="stylesheet" href="<?= asset('css/panel.css') ?>">
        </head>

    <?php
    }

    protected function getAdminNavbar()
    {
        $user = Auth::getLoggedUser();
    ?>
        <nav>
            <ul>
                <li><a href="<?= url('index.php') ?>">Website</a></li>
                <li><a href="<?= url('panel.php', ['action' => 'posts']) ?>">Posts</a></li>
                <li><a href="<?= url('panel.php', ['action' => 'create']) ?>">Create Post</a></li>
                <li><a href="<?= url('panel.php', ['action' => 'logout']) ?>">Logout</a></li>

            </ul>
            <ul>
                <li>
                    <?= $user->getFullName(); ?>
                </li>
            </ul>
        </nav>
    <?php
    }
    protected function getHeader()
    {
    ?>
        <header>
            <h1> <?= $this->setting->getTitel() ?> </h1>
            <div id="logo">
                <img src="<?= asset($this->setting->getLogo())  ?> " alt="<?= $this->setting->getTitel() ?>">
            </div>
        </header>
    <?php
    }

    protected function getNavbar()
    {
    ?>
        <nav>
            <ul>
                <li> <a href=" <?= url('index.php') ?> ">Home</a> </li>
                <li> <a href=" <?= url('index.php', ['action' => 'category', 'category' => 'scientific']) ?> ">Scientific</a> </li>
                <li> <a href=" <?= url('index.php', ['action' => 'category', 'category' => 'technology']) ?> ">Technology</a> </li>
                <li> <a href=" <?= url('index.php', ['action' => 'category', 'category' => 'research']) ?> ">Research</a> </li>
                <li> <a href=" <?= url('index.php', ['action' => 'category', 'category' => 'design']) ?> ">Design</a> </li>
                <li> <a href=" <?= url('index.php', ['action' => 'login']) ?> ">Login</a> </li>

            </ul>
            <form action="index.php" method="GET">
                <input type="hidden" name="action" value="search">
                <input type="text" name="word" placeholder="Search your word" value="<?= $this->request->has('word') ? $this->request->word : '' ?>">
                <input type="submit" value="Search">
            </form>
        </nav>
    <?php
    }


    protected function getSidebar($topPosts, $lastPots)
    {
    ?>
        <aside>
            <?php if (count($topPosts)) : ?>
                <div class="aside-box">
                    <h2>Top Posts </h2>
                    <ul>
                        <?php foreach ($topPosts as $item):  ?>
                            <li>
                                <a href="<?= url('index.php', ['action' => 'single', 'id' => $item->getid()]) ?>">
                                    <?= $item->getTitel() ?> <small>(<?= $item->getview(); ?>)</small>
                                </a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>
            <?php if (count($lastPots)): ?>
                <div class="aside-box">
                    <h2>Last Posts</h2>
                    <ul>
                        <?php foreach ($lastPots as $item): ?>
                            <li>
                                <a href="<?= url('index.php', ['action' => 'single', 'id' => $item->getid()]) ?>">
                                    <?= $item->getTitel() ?> <small>(<?= $item->getdata(); ?>) </small>
                                </a>
                            </li>
                        <?php endforeach  ?>
                    </ul>
                </div>
            <?php endif ?>
        </aside>
    <?php
    }

    protected function getFooter()
    {
    ?>
        <footer>
            <p> <?= $this->setting->getFooter() ?> </p>
        </footer>
<?php
    }


    abstract public function renderPage();
}
