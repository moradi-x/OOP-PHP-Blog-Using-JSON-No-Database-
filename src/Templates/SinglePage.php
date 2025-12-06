<?php

namespace app\Templates;

use app\Exceptions\NotFoundException;
use app\Models\post;

class SinglePage extends Template
{

    private $post;
    private $topPost;
    private $lastPots;

    public function __construct()
    {
        parent::__construct();
        if (!$this->request->has('id'))
            throw new NotFoundException('Page not found!...');
        $id = $this->request->get('id');
        $postModel = new post();
       $this->post = $postModel->getDataById($id) ;
        $this->titel = $this->setting->gettitel() . '-' . $this->post->gettitel();

        $this->topPost = $postModel->sortData(function($first,$secend){
            return $first->getview() > $secend->getview() ? -1 : 1 ;
        });

        $this->lastPots = $postModel->sortData(function($first,$secend){
            return $first->gettimestamp() > $secend->gettimestamp() ? -1 :1 ;
        });
    }

    public function renderPage() {
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
                            <article>
                                <div class="caption">
                                    <h3><?= $this->post->getTitel() ?></h3>
                                    <ul>
                                        <li>Data : <span><?= $this->post->getdata()  ?></span></li>
                                        <li>Views : <span><?= $this->post->getview(); ?> view</span></li>
                                    </ul>
                                    <p>
                                        <?= $this->post->getContent() ?>
                                    </p>
                                </div>
                                <div class="image">
                                    <img src="<?= asset($this->post->getImage()) ?>" alt="<?= $this->post->gettitel(); ?>">
                                </div>
                                <div class="clearfix"></div>
                            </article>
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
