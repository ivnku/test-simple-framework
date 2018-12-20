<?php

namespace TestFramework\App\Controllers;

use TestFramework\Core\Controller;
use TestFramework\Core\View;

/**
 * Controller for the Posts page
 */
class Posts extends Controller
{
    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Posts/index.html');
        echo '<p>Query string parameters: <pre>' . htmlspecialchars(print_r($_GET, true)) . '</pre></p>';
    }

    /**
     * Add new post
     *
     * @return void
     */
    public function addAction()
    {
        echo 'Add a new post. The Posts controller.';
    }

    /**
     * Show edit page
     *
     * @return void
     */
    public function editAction()
    {
        echo 'Hello from the edit action in the Posts controller';
        echo '<p>Route params:<pre>' . htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
    }
}