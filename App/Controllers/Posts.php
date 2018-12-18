<?php

namespace TestFramework\App\Controllers;

use TestFramework\Core\Controller;

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
        echo 'The index page of the Posts controller. <br/>';
        echo '<p>Query string parameters: <pre>' . htmlspecialchars(print_r($_GET, true)) . '</pre></p>';
    }

    /**
     * Add new post
     *
     * @return void
     */
    public function addAction()
    {
        echo 'Add new post in the Posts controller.';
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