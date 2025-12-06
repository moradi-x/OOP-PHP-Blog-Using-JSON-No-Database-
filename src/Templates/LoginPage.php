<?php

namespace app\Templates;

use app\Clases\Auth;
use app\Models\User;

class LoginPage extends Template
{

    private $errors = [];

    public function __construct()
    {
        parent::__construct();
        // Auth::logoutUser();
        if (Auth::isAuthenticated())
            redirect('panel.php', ['action' => 'posts']);

        $this->titel = $this->setting->getTitel() . ' - login to system';

        if ($this->request->isPostMethod()) {
            $data = $this->validator->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'min:6']
            ]);
            if (!$data->hasError()) {
                $userModel = new User();
                $user = $userModel->authenticatUser($this->request->email, $this->request->password);
                if ($user) {
                    Auth::loginUser($user);
                    redirect('panel.php', ['action' => 'posts']);
                } else {

                    $this->errors[] = 'invalid credential';
                }
            } else {
                $this->errors = $data->getErrors();
            }
        }
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
        <html lang="en">
        <?= $this->getAdminHead()  ?>

        <body>
            <main>
                <form action="<?= url('index.php', ['action' => 'login']) ?>" method="POST">
                    <div class="login">
                        <h3>Login to system</h3>
                        <?php $this->showError() ?>
                        <div>
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email">
                        </div>
                        <div>
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password">
                        </div>
                        <div>
                            <input type="submit" value="Login">
                        </div>
                    </div>
                </form>
            </main>
        </body>

        </html>
<?php
    }
}
