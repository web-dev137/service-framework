<?php
use App\handlers\api\PostApi;
use App\handlers\Site;
use App\utils\Router;

Router::post("/api/post",PostApi::class,"create");
Router::get("/api/post", PostApi::class,"index");
Router::get("/api/post/view",PostApi::class,"view");
Router::patch("/api/post", PostApi::class,"update");
Router::get("/docs", Site::class,"docs");