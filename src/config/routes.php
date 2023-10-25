<?php
$router = router();

$router->get("/", \http\Welcome::class);
