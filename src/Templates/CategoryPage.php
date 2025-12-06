<?php

namespace app\Templates;

use app\Exceptions\NotFoundException;
use app\Models\post;

class CategoryPage extends Template
{
    private $posts;
    private $topPost;
    private $lastPots;

    public function __construct()
    {
        parent::__construct();
        if (!$this->request->has('category'))
            throw new NotFoundException('Page not found');
        $category = $this->request->category;
        // در خط بالا کتگوری رو از کوئری استرینگ یعنی یو ار ال خوند و در کلاس ریکوئس
        // چون این پراپرتی یا متد وجود نداره متد جادویی __گت فراخونی میشه

        $this->titel = $this->setting->gettitel() . '-' . $category;
        $postModel = new post();                     

        $this->posts = $postModel->filterData(function($item) use ($category) {
            return $item->getCategory() == $category ? true : false;
        });
        $this->topPost = $postModel->sortData(function ($first, $second) {
            return $first->getview() > $second->getview() ? -1 : 1;
        });

        $this->lastPots = $postModel->sortData(function ($first, $second) {
            return $first->getTimesTamp() > $second->getTimesTamp() ? -1 : 1;
        });
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
