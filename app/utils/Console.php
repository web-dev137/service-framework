<?php

namespace App\utils;


final class Console
{
    public function run($config=[],$argv=[]): bool
    {
        $passedArguments = count($argv);//php command.php -c <your command> <--param1=val1 --param2=val2...>
        if($argv && $passedArguments>=3) {
            App::setDb($config);
            RouterConsole::loadRoutes($argv);
            return true;
        } else{
            echo "3 arguments must be passed". $passedArguments ."passed";
            return false;
        }
    }
}