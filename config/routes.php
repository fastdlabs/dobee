<?php

route()->get('/', 'IndexController@sayHello');
route()->get('/{name}', 'IndexController@dynamic');
