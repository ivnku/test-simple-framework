<?php

namespace TestFramework\App\Controllers\Admin;

use TestFramework\Core\Controller;

class Users extends Controller
{
    /**
     * Function which is called before an any action
     *
     * @return void
     */
    protected function before()
    {
        //Make sure an admin user is logged in
    }

    /**
     * Show the admin index page
     *
     * @return void
     */
    public function indexAction()
    {
        echo 'The user ADMIN index page.';
    }
}