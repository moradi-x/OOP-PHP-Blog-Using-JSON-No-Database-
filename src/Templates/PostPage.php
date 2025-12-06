<?php

namespace app\Templates;

use app\Models\post;
use app\Clases\Session ;

class PostPage extends Template
{
    private $posts;

    public function __construct()
    {
        parent::__construct();

        $this->titel = $this->setting->getTitel() . ' - Admin panel - All Posts';
        $postModel = new post();
        $this->posts = $postModel->getAllData();
    }

    private function showMassege()
    {
        if (session::get('message')):
?>
            <div class=" message"><?= session::flush('message') ?></div>
        <?php
        endif;
    }


    public function renderPage()
    {
        ?>
        <html>
        <?php $this->getAdminHead() ?>

        <body>
            <main>
                <?php $this->getAdminNavbar() ?>
                <section class="content">
                    <?php $this->showMassege() ?>
                    <?php if (count($this->posts)): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Titel</th>
                                    <th>Category</th>
                                    <th>View</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->posts as $post): ?>
                                    <tr>
                                        <td><?= $post->getId() ?></td>
                                        <td><?= $post->getTitel() ?></td>
                                        <td><?= $post->getCategory() ?></td>
                                        <td><?= $post->getView() ?> View</td>
                                        <td><?= $post->getData() ?></td>
                                        <td>
                                            <a class="a1" href="<?= url('panel.php', ['action' => 'edit', 'id' => $post->getId()]) ?>">Edit</a>
                                            <a class="a2" href="<?= url('panel.php', ['action' => 'delete', 'id' => $post->getId()]) ?>">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach  ?>
                            </tbody>
                        </table>
                    <?php endif ?>
                </section>
            </main>
        </body>
<?php
    }
}
