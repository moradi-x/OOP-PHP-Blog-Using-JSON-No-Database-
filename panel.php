<?php
session_start();
require './vendor/autoload.php';

use app\Clases\Auth;
use app\Clases\Request;
use app\Exceptions\DosNotExistsException;
use app\Exceptions\NotFoundException;
use app\Templates\createPage;
use app\Templates\DeletePage;
use app\Templates\EditPage;
use app\Templates\ErrorPage;
use app\Templates\NotFoundPage;
use app\Templates\PostPage;


try {
    Auth::checkAuthenticated();

    $request = new Request();

    switch ($request->get('action')) {
        case 'posts':
            $page =  new PostPage();
            break; 
        case 'create':
            $page = new createPage();
            break;
        case 'edit':
            $page =  new EditPage();
            break;
        case 'delete':
            $page = new DeletePage();
            break;
        case 'logout':
            Auth::logoutUser();
            break;
        default:
            throw new NotFoundException('not found page!...');
            break;
    }
} catch (NotFoundPage | DosNotExistsException $e) {
    $page = new NotFoundPage($e->getMessage());
} catch (Exception $e) {
    $page = new ErrorPage($e->getMessage());
} finally {
    $page->renderPage();
}
