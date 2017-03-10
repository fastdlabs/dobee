<?php

route()->get(['/', 'name' => 'welcome'], 'IndexController@welcome');
route()->get(['/hello/{name}', 'name' => 'hello'], 'IndexController@sayHello');
