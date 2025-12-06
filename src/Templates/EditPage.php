<?php

namespace app\Templates;

use app\Clases\Session;
use app\Models\post;


class EditPage extends Template
{

    private $post;
    private $errors = [];

    public function __construct()
    {
        parent::__construct();

        if (!$this->request->has('id'))
            redirect('panel', ['action' => 'posts']);

        $id = $this->request->id;
        $postModel = new post();
        $this->post = $postModel->getDataById($id);

        $this->titel = $this->setting->getTitel() . 'Admin panel - Edit post: ' . $this->post->getTitel();

        if ($this->request->isPostMethod()) {
            $data = $this->validator->validate([
                'titel' => ['required', 'min:3', 'max:50'],
                'category' => ['required', 'in:scientific,technology,research,design'],
                'content' => ['required', 'min:3', 'max:5000'],
                'image' => ['unllable', 'file', 'type:jpg,png', 'size:2048']
            ]);

            if (!$data->hasError()) {
                $this->updatePost($postModel);
            } else {
                $this->errors = $data->getErrors();
            }
        }
    }

    private function updatePost($postModel)
    {
        $this->post->setTitel($this->request->titel);
        $this->post->setContent($this->request->content);
        $this->post->setCategory($this->request->category);

        if ($this->request->image->isFile()) {
            deletedFile($this->post->getImage()) ;
            $image = $this->request->image->Upload();
            $this->post->setImage($image);
        }

        $postModel->editData($this->post);
        Session::flush('message', ' Post was updated...');

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
                            <input type="text" name="titel" id="titel" value="<?= $this->post->getTitel()  ?>">

                            <label for="category">Category</label>
                            <select name="category" id="category">
                                <option value="scientific" <?= ($this->post->getCategory() == "scientific") ? 'selected' : '' ?>>scientific</option>
                                <option value="technology" <?= ($this->post->getCategory() == "technology") ? 'selected' : '' ?>>technology</option>
                                <option value="research" <?= ($this->post->getCategory() == "research") ? 'selected' : '' ?>>research</option>
                                <option value="design" <?= ($this->post->getCategory() == "design") ? 'selected' : '' ?>>design</option>
                            </select>
                        </div>
                        <div>
                            <label for="content">Content</label>
                            <textarea name="content" id="content" cols="30" rows="10"><?= $this->post->getContent() ?></textarea>
                        </div>
                        <div>
                            <label for="image">Image</label>
                            <input type="file" name="image" id="image">
                            <img class="image" src="<?= asset($this->post->getImage()) ?>" alt="image">
                        </div>
                        <div>
                            <input type="submit" value="Update post">
                        </div>
                    </form>
                </section>
            </main>
        </body>

        </html>
<?php
    }
}
