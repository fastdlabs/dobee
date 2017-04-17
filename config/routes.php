<?php

route()->get('/', 'WelcomeController@welcome');
route()->get('/hello/{name}', 'WelcomeController@sayHello');
