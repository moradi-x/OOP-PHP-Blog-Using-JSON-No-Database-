<?php

namespace app\Templates;

use app\Models\post;
use app\Clases\Session ;

class DeletePage extends Template
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->request->has('id'))
            redirect('panel.php', ['action' => 'posts']);

        $id = $this->request->get('id');
        $postModel = new post();
        $post = $postModel->getDataById($id);

        $postModel->deleteData($post->getId());

        deletedFile($post->getImage());

        session::flush('message', 'Post was deleted...');
        redirect('panel.php', ['action' => 'posts']);
    }

    public function renderPage()
    {
        echo "delete page";
    }
}
