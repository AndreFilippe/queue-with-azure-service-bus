<?php

namespace App\Console\Commands;

use App\Services\ServiceBusService;
use Illuminate\Console\Command;

class ServiceBusReceive extends Command
{
    protected $signature = 'app:service-bus-receive {queue=null}';
    protected $description = 'Listen to the service bus queue';

    public function handle(ServiceBusService $serviceBusReceive)
    {
        $queue = ($this->argument('queue') === 'null')
            ? config('servicebus.queues.default') :
            $this->argument('queue');

        $serviceBusReceive->setQueue($queue);

        echo 'Listening...' . PHP_EOL;
        while (true) {
            echo now() . ' Recebendo...' . PHP_EOL;
            $message = $serviceBusReceive->receive();
            if (!empty($message->body())) {
                info('Recebido', [$message->body()]);
                echo 'Recebido: ' . $message->body() . PHP_EOL;
            }
        }
        echo 'Done' . PHP_EOL;
    }
}
