<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ServiceBusService
{
    private array $headers;
    private string $queue;

    private const URIS = [
        'SEND' => 'messages',
        'RECEIVE' => 'messages/head'
    ];

    public function __construct()
    {
        $this->setQueue(config('servicebus.queues.default'));
    }

    public function setQueue(string $queue)
    {
        $this->queue = $queue;

        $this->setHeaders(
            config('servicebus.url'),
            config('servicebus.police'),
            config('servicebus.key')
        );

        return $this;
    }

    /**
     * @param integer $scheduled
     * $scheduled minutes to send message
     */
    public function send($message, ?string $id = null, int $scheduled = 0)
    {
        $headers = $this->headers;
        if ($scheduled) {
            $ScheduledEnqueueTimeUtc = Carbon::parse(now())->addMinutes($scheduled)->setTimezone('GMT')->format('D, j M Y H:i:s e');
            $headers['BrokerProperties']['ScheduledEnqueueTimeUtc'] = $ScheduledEnqueueTimeUtc;
        }

        if ($id) {
            $headers['BrokerProperties']['MessageId'] = $id;
        }

        if (isset($headers['BrokerProperties'])) {
            $headers['BrokerProperties'] = json_encode($headers['BrokerProperties']);
        }

        return Http::withHeaders($headers)
            ->post($this->getUri('send'), [
                'body' => $message
            ])->status();
    }

    public function receive($destructive = true)
    {
        $response = Http::withHeaders($this->headers)
            ->when($destructive, function ($request) {
                return $request->delete($this->getUri('receive'));
            }, function ($request) {
                return $request->post($this->getUri('receive'));
            });

        return $response;
    }

    public function setHeaders(string $url, string $keyName, string $key)
    {
        $this->headers = [
            'Authorization' => $this->getTokem(
                $url . '/' . $this->queue,
                $keyName,
                $key
            ),
            'Content-Type' => 'application/json'
        ];
    }

    private function getTokem(string $resourceUri, string $keyName, string  $key)
    {
        $targetUri = strtolower(rawurlencode(strtolower($resourceUri)));
        $expires = time();
        $week = 60 * 60 * 24 * 7;
        $expires = $expires + $week;
        $toSign = $targetUri . "\n" . $expires;
        $signature = rawurlencode(base64_encode(hash_hmac('sha256', $toSign, $key, TRUE)));

        $token = "SharedAccessSignature sr=" . $targetUri . "&sig=" . $signature . "&se=" . $expires .         "&skn=$keyName";
        return $token;
    }

    private function getUri(string $uri)
    {
        $uri = self::URIS[strtoupper($uri)];
        return config('servicebus.url') . '/' . $this->queue . '/' . $uri;
    }
}
