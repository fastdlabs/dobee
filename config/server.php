<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

return [
    'listen' => 'http://127.0.0.1:9533',
    'options' => [
        'pid_file' => '',
        'worker_num' => 10
    ],
    'discovery' => [
        'tcp://127.0.0.1:9888'
    ],
    'processes' => [
        \Processor\ServerProcessor::class,
    ],
    'ports' => [
        [
            'class' => \Port\MultiPort::class,
            'listen' => 'tcp://127.0.0.1:9528',
            'options' => [

            ],
        ],
    ],
];