<?php

namespace app\Templates;

use app\Entites\PostEntites;
use app\Models\post;
use app\Clases\Session ;

class CreatePage extends Template
{

    private $errors = [];

    public function __construct()
    {
        parent::__construct();

        $this->titel = $this->setting->getTitel() . ' - Admin panel - Create post';

        if ($this->request->isPostMethod()) {
            $data = $this->validator->validate([
                'titel' => ['required', 'min:3', 'max:50'],
                'category' => ['required', 'in:scientific,technology,research,design'],
                'content' => ['required', 'min:3', 'max:5000'],
                'image' => ['required', 'file', 'type:jpg,png', 'size:2048']
            ]);

            if (!$data->hasError()) {
                $this->createPost();
            } else {
                $this->errors = $data->getErrors();
            }
        }
    }

    public function createPost()
    {
        $postModel = new post();
        $post = new PostEntites([
            'id' => $postModel->getLastData()->getId() + 1,  // چون خروجیش ابجگتی هست دسترسی دراه به گت ایدی
            'titel' => $this->request->titel,
            'content' => $this->request->content,
            'category' => $this->request->category,
            'view' => 0,
            'image' => $this->request->image->Upload(), // برای ذخیره در جیسون
            'data' => date('Y-m-d H:i:s')
        ]);

        $postModel->createData($post);

        session::flush('message', 'New Post was created...');

        redirect('panel.php', ['action' => 'posts']);
    }
    private function showError()
    {
        if (count($this->errors)) {
?>
            <div class="errors">
                <ul>
                    <?php foreach ($this->errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach  ?>
                </ul>
            </div>
        <?php
        }
    }

    public function renderPage()
    {
        ?>
        <html>

        <?php $this->getAdminHead() ?>

        <body>
            <main>
                <?php $this->getAdminNavbar()  ?>
                <section class="content">
                    <?= $this->showError() ?>
                    <form method="POST" enctype="multipart/form-data">
                        <div>
                            <label for="titel">Titel</label>
                            <input type="text" name="titel" id="titel" value="<?= $this->request->has('titel') ? $this->request->titel : ''   ?>">

                            <label for="category">Category</label>
                            <select name="category" id="category">
                                <option value="scientific" <?= ($this->request->has('category') and $this->request->category == "scientific") ? 'selected' : '' ?>>scientific</option>
                                <option value="technology" <?= ($this->request->has('category') and $this->request->category == "technology") ? 'selected' : '' ?>>technology</option>
                                <option value="research" <?= ($this->request->has('category') and $this->request->category == "research") ? 'selected' : '' ?>>research</option>
                                <option value="design" <?= ($this->request->has('category') and $this->request->category == "design") ? 'selected' : '' ?>>design</option>
                            </select>
                        </div>
                        <div>
                            <label for="content">Content</label>
                            <textarea name="content" id="content" cols="30" rows="10"><?= $this->request->has('content') ? $this->request->content : ''   ?></textarea>
                        </div>
                        <div>
                            <label for="image">Image</label>
                            <input type="file" name="image" id="image">
                        </div>
                        <div>
                            <input type="submit" value="Create post">
                        </div>
                    </form>
                </section>
            </main>
        </body>

        </html>
<?php
    }
}
