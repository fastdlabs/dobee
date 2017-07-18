<?php

namespace Controller;


use FastD\Http\ServerRequest;
use Phpml\Classification\SVC;
use Phpml\SupportVectorMachine\Kernel;

class MlController
{
    public function svc(ServerRequest $request)
    {
        $samples = [
            [1, 3],
            [1, 4],
            [2, 4],
            [3, 1],
            [4, 1],
            [4, 2],
            [4, 2],
            [4, 2],
            [4, 2],
            [4, 2],
            [4, 2],
        ];
        $labels = [
            '普通用户',
            'a',
            'a',
            'b',
            'b',
            'b',
        ];

        $svc = new SVC(Kernel::LINEAR, $cost = 1000);

        $svc->train($samples, $labels);

        $result = $svc->predict([1, 1]);

        return json([
            'result' => $result,
        ]);
    }
}