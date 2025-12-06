<?php 

namespace app\Templates ;

use app\Exceptions\NotFoundException;
use app\Models\post;

class SerchPage extends Template{
    private $posts ;
    private $topPost;
    private $lastPots ;

    public function __construct()
    {
        parent::__construct();

        if(!$this->request->has('word'))
           throw new NotFoundException('Page not found');
        $word = $this->request->word; // مهم 
        $this->titel = $this->setting->gettitel(). '- result for: ' . $word ;

        $postModel = new post();
        $this->posts = $postModel->filterData(function($item) use($word) {
            return str_contains($item->getTitel(),$word) or str_contains($item->getContent(),$word) ? true : false;
            // این تابع اس تی ار کانتیس  بهبود شده تابع اس تی ار پوس هست یعنی ایا این رشته شامل زیر رشته هست یا نه 
            // ورودی اول رشته ای که میخوایم درش جستجو کنیم  و ورودی دوم زیر رشته هست 
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