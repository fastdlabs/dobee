<?php

namespace Controller;


use FastD\Http\Response;
use FastD\Http\ServerRequest;
use Phpml\Classification\KNearestNeighbors;

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
        ];
        $labels = [
            'a',
            'b',
            'c',
            'd',
            'e',
            'f',
        ];

        $classifier = new KNearestNeighbors();
        $classifier->train($samples, $labels);

        return json([
            'result' => $classifier->predict([1, 4]),
        ]);
    }
}