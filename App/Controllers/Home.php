<?php

namespace TestFramework\App\Controllers;

use TestFramework\Core\Controller;
use TestFramework\Core\View;

/**
 * Controller for the home page
 */
class Home extends Controller
{
    protected function before()
    {
        echo '(before)';
    }

    protected function after()
    {
        echo '(after)';
    }
    
    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $data = [
            'name'=>'Ivan',
            'colours' => ['red', 'green', 'blue']
        ];
        View::renderTemplate('Home/index.html', $data);
    }
}