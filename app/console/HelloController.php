<?php
namespace App\console;

use \App\models\Course;
use \App\models\Valute;
use App\utils\App;

class HelloController
{

    /**
     * This command echoes what you have entered as the message.
     * @param string $msg the message to be echoed.
     */
    public function index(string $msg="Hello World!")
    {
        echo $msg;
        exit(0);
    }

}
