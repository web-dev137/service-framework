<?php
use App\utils\RouterConsole;

RouterConsole::route("hello/index",\App\console\HelloController::class,"index");