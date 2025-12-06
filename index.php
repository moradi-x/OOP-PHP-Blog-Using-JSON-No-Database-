<?php
require "./vendor/autoload.php";
session_start();

use app\Clases\Request;
use app\Exceptions\DosNotExistsException;
use app\Exceptions\NotFoundException;
use app\Templates\CategoryPage;
use app\Templates\MainPage;
use app\Templates\NotFoundPage;
use app\Templates\SerchPage;
use app\Templates\SinglePage;
use app\Templates\ErrorPage;
use app\Templates\LoginPage;

try {
    $request = new Request();
    switch ($request->get('action')) {
        case 'single':
            $page = new SinglePage();
            break;
        case 'search':
            $page = new SerchPage();
            break;
        case 'category':
            $page = new CategoryPage();
            break;
        case null:
            $page = new MainPage();
            break;
        case 'login';
            $page = new LoginPage();
            break;
        default:
            throw new NotFoundException('page not found!...');
            break;
    }
} catch (NotFoundException | DosNotExistsException $e) {
    $page  = new NotFoundPage($e->getMessage());
} catch (Exception $e) {
    $page = new ErrorPage($e->getMessage());
} finally {
    $page->renderPage();
}
