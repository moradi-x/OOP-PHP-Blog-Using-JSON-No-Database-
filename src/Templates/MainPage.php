<?php

namespace app\Templates;

use app\Models\post;

class MainPage extends Template
{
    private $topPost;
    private $lastPots;
    private $posts;

    public function __construct()
    {
        parent::__construct();
        $this->titel = $this->setting->getTitel();

        $postModel = new post();

        $this->topPost = $postModel->sortData(function ($first, $second) {
            return $first->getview() > $second->getview() ? -1 : 1;
        });

        $this->lastPots = $postModel->sortData(function ($first, $second) {
            return $first->getTimesTamp() > $second->getTimesTamp() ? -1 : 1;
        });
        $this->posts = $postModel->getAllData();
    }

    public function renderPage()
    {
?>
        <html lang="en">
        <?php $this->getHead(); ?>

        <body>
            <main>
                <?php $this->getHeader();  ?>
                <?php $this->getNavbar();  ?>
                <section id="content">
                    <?php $this->getSidebar($this->topPost, $this->lastPots) ?>
                    <div id="articles">
                        <?php foreach ($this->posts as $post): ?>
                            <article>
                                <div class="caption">
                                    <h3><?= $post->getTitel() ?></h3>
                                    <ul>
                                        <li>Data : <span><?= $post->getdata()  ?></span></li>
                                        <li>Views : <span><?= $post->getview(); ?> view</span></li>
                                    </ul>
                                    <p>
                                        <?= $post->getExcerpt() ?>
                                    </p>
                                    <a href="<?= url('index.php',['action'=>'single' ,'id'=> $post->getid()]) ?>">More...</a>
                                </div>
                                <div class="image">
                                    <img src="<?= asset($post->getImage()) ?>" alt="<?= $post->gettitel(); ?>">
                                </div>
                                <div class="clearfix"></div>
                            </article>
                        <?php endforeach ?>
                    </div>
                    <div class="clearfix"></div>

                </section>
                <?php $this->getFooter() ?>
            </main>
        </body>

        </html>
<?php
    }
}
