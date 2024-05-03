<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PAMI\Client\Impl\ClientImpl;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ListenController extends Controller
{
    protected $client;

    public function __construct()
    {
        $options = array(
            'host' => '10.100.0.78',
            'scheme' => 'tcp://',
            'port' => 5038,
            'username' => 'listen',
            'secret' => 'interactx123',
            'connect_timeout' => 10000,
            'read_timeout' => 10000,
        );

        $client = new ClientImpl($options);
        $client->open();

        $client->registerEventListener(function ($event) {
            if ($event instanceof \PAMI\Message\Event\PeerStatusEvent) {
                dd($event); // Usando dd() para exibir os detalhes do evento
            }
        });

        while (true) {
            usleep(1000);
            $client->process();
        }

        $client->close();
    }
}
