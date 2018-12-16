<?php

namespace Enkelad\TestFramework\App\Controllers;

/**
 * Controller for the Posts page
 */
class Posts
{
    /**
     * Show the index page
     *
     * @return void
     */
    public function index()
    {
        echo 'The index page of the Posts controller. <br/>';
        echo '<p>Query string parameters: <pre>' . htmlspecialchars(print_r($_GET, true)) . '</pre></p>';
    }

    /**
     * Add new post
     *
     * @return void
     */
    public function addNew()
    {
        echo 'Add new post in the Posts controller.';
    }
}