<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Log;
use Mailjet\Client;
use Mailjet\Resources;

class MailMessage
{
    protected array $body = [];
    protected string $from;
    protected string $subject;
    private array $merchantService;

    public function __construct(array $merchant)
    {
        $this->merchantService = $merchant['services']['mailjet'];
        $this->from($this->merchantService['configs']['public_key'], $merchant['name'] . ' no reply');
    }

    public function view(string $view, array $params): self
    {
        $html = view($view, $params)->render();

        $this->body['HTMLPart'] = $html;

        return $this;
    }

    public function subject($subject = ''): self
    {
        $this->body['Subject'] = $subject;

        return $this;
    }

    public function to(string $to, string $name = ''): self
    {
        $this->body['To'][] = [
            'Email' => $to,
            'Name' => $name,
        ];

        return $this;
    }

    public function from(string $from, string $name = ''): self
    {
        $this->body['From']['Email'] = $from;
        $this->body['From']['Name'] = $name;

        return $this;
    }

    public function send(): mixed
    {
        if (! array_key_exists('Subject', $this->body) && array_key_exists('HTMLPart', $this->body) && array_key_exists('To', $this->body)) {
            throw new \RuntimeException('Methods subject, html and to are required.');
        }

        $response = (new Client($this->merchantService['configs']['username'], $this->merchantService['configs']['password'], true, ['version' => 'v3.1']))
            ->post(Resources::$Email, ['body' => ['Messages' => [$this->body]]]);

        if ($response->success()) {
            Log::info('Mail Notification: The email: ' . json_encode($this->body['To']) . ' is valid.');
            return true;
        }

        Log::alert('Mail Notification - Exception:' . json_encode($response->getData()));
        return false;
    }
}
