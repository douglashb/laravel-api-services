<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class SmsMessage
{
    protected array $lines;
    protected string $from;
    protected string $to;
    protected string $dryrun = 'no';
    private array $merchantService;

    public function __construct(array $merchant)
    {
        $this->merchantService = $merchant['services']['twilio'];
        $this->from = $this->merchantService['configs']['public_key'];
    }

    public function line($line = ''): self
    {
        $this->lines[] = $line;

        return $this;
    }

    public function to($to): self
    {
        $this->to = $to;

        return $this;
    }

    public function from($from): self
    {
        $this->from = $from;

        return $this;
    }

    public function send(): mixed
    {
        if (! $this->from || ! $this->to || ! count($this->lines)) {
            throw new \RuntimeException('Methods From, To and Lines are required.');
        }

        try {
            (new Client($this->merchantService['configs']['username'], $this->merchantService['configs']['password']))
                ->messages
                ->create(
                    $this->to,
                    [
                        'body' => count($this->lines) > 1 ? implode("\n", $this->lines) : $this->lines[0],
                        'from' => $this->from,
                    ]
                );

            Log::info('SMS Notification: The number: ' . $this->to . ' is valid.');

            return true;
        } catch (\Exception|ConfigurationException $e) {
            Log::alert('SMS Notification - Exception:' . $e->getMessage());
        }

        return false;
    }
}
