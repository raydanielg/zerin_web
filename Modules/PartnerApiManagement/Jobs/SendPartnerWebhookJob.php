<?php

namespace Modules\PartnerApiManagement\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendPartnerWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(
        protected string $webhookUrl,
        protected ?string $webhookSecret,
        protected array $payload
    ) {
    }

    public function handle(): void
    {
        $body = json_encode($this->payload);
        $headers = ['Content-Type' => 'application/json'];

        if ($this->webhookSecret) {
            $headers['X-Webhook-Signature'] = hash_hmac('sha256', $body, $this->webhookSecret);
        }

        try {
            Http::withHeaders($headers)->timeout(10)->post($this->webhookUrl, $this->payload);
        } catch (\Exception $exception) {
            Log::error('Partner webhook delivery failed', [
                'url' => $this->webhookUrl,
                'exception' => $exception->getMessage(),
            ]);
        }
    }
}
