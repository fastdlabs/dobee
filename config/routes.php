<?php

$route = route();

$route->get('/', 'WelcomeController@welcome');

$route->get('/ml/svc', 'MlController@svc');
