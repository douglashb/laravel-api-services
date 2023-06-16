<?php

namespace App\Services;

//use App\Mail\ClientExceptionCatched;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\TransferStats;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class Client
{
    private array $requestParts = [];
    private string $typeRequest = 'json';
    private string $baseUri;
    private int $statusCode;
    private string $transferTime;

    /**
     * @param string $baseUri
     *
     * @return void
     */
    public function setBaseUri(string $baseUri = ''): void
    {
        $this->baseUri = $baseUri;
    }

    /**
     * @param string $typeRequest
     *
     * @return void
     */
    public function setTypeRequest(string $typeRequest): void
    {
        $this->typeRequest = $typeRequest;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->requestParts['headers'] = array_key_exists('headers', $this->requestParts) ? array_merge($headers, $this->requestParts['headers']) : $headers;
    }

    /**
     * @param string $url
     * @param array|null $params
     *
     * @return array
     */
    public function get(string $url, array|null $params = null): array
    {
        if ($params !== null) {
            $this->requestParts[$this->typeRequest] = $params;
        }

        return $this->execute('GET', $url);
    }

    /**
     * @param string $url
     * @param object|array|null $body
     *
     * @return array
     */
    public function delete(string $url, object|array|null $body = null): array
    {
        if ($body !== null) {
            $this->requestParts[$this->typeRequest] = (array) $body;
        }

        return $this->execute('DELETE', $url);
    }

    /**
     * @param string $url
     * @param object|array|string|null $body
     *
     * @return array
     */
    public function put(string $url, object|array|string|null $body = null): array
    {
        if ($body !== null) {
            $this->requestParts[$this->typeRequest] = is_string($body) ? $body : (array) $body;
        }

        return $this->execute('PUT', $url);
    }

    /**
     * @param string $url
     * @param object|array|string|null $body
     *
     * @return array
     */
    public function post(string $url, object|array|string|null $body = null): array
    {
        if ($body !== null) {
            $this->requestParts[$this->typeRequest] = is_string($body) ? $body : (array) $body;
        }

        return $this->execute('POST', $url);
    }

    /**
     * @param string $method
     * @param string $url
     *
     * @return array
     */
    private function execute(string $method, string $url): array
    {
        $this->defaultGuzzleConfigs();

        try {
            $response = (new GuzzleClient())->request($method, $this->baseUri . $url, $this->requestParts);
        } catch (GuzzleException $e) {
            $this->statusCode = $e->getCode();
            $this->logExecute($method, $url, $e->getMessage(), false);

            return $this->exceptionHandler($method, $url, $e->getMessage());
        }

        $this->statusCode = $response->getStatusCode();
        $strResult = preg_replace('/^[ \t]*[\r\n]+/m', '', $response->getBody()->getContents());

        if (App::environment(['local', 'develop'])) {
            $this->logExecute($method, $url, $strResult);
        }

        try {
            return json_decode($strResult, true, 512, JSON_THROW_ON_ERROR);
        } catch (\Exception $exception) {
            $this->logExecute($method, $url, $exception->getMessage(), false);
            return $this->exceptionHandler('json_decode', '', $exception->getMessage());
        }
    }

    /**
     * @return void
     */
    private function defaultGuzzleConfigs(): void
    {
        $this->requestParts['verify'] = false;
        //$this->requestParts['timeout'] = '6'; // seconds
        $this->requestParts['on_stats'] = function (TransferStats $stats) {
            $this->transferTime = $stats->getTransferTime();
        };
    }

    /**
     * @param string $method
     * @param string $url
     * @param object|string $response
     *
     * @return array
     */
    private function exceptionHandler(string $method, string $url, object|string $response = ''): array
    {
        try {
            $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        } catch (\Exception $exception) {
            $response = [
                'code' => $this->statusCode,
                'responseCode' => '59906004',
                'message' => empty($response) ? 'OFF LINE SERVICE!' : $response,
                'responseMessage' => __('api.service_down_title'),
            ];
        }
//        Mail::to(config('internal.exception.email'))
//            ->send(new ClientExceptionCatched($strException, $this->statusCode, $this->baseUri . $url, $method));

        return $response;
    }

    private function logExecute(string $method, string $url, object|string $result = '', bool $success = true): void
    {
        Log::debug('╔════════════════════════════');
        Log::debug('║ REQUEST:  HTTP/' . $method . ' - ' . $this->baseUri . $url);

        if (array_key_exists('headers', $this->requestParts)) {
            Log::debug('║ HEADER: ' . json_encode($this->requestParts['headers']));
        }

        if (array_key_exists($this->typeRequest, $this->requestParts) && App::environment(['local', 'develop'])) {
            $body = is_string($this->requestParts[$this->typeRequest]) ? $this->requestParts[$this->typeRequest] : json_encode($this->requestParts[$this->typeRequest]);
            Log::debug('║ BODY: ' . $body);
        }

        Log::debug('║ REQUEST TIME: ' . $this->transferTime . ' seconds');

        if ($success) {
            Log::debug('║ ʘ‿ʘ RESPONSE: ' . $this->statusCode . ' - ' . $result);
        } else {
            Log::debug('║ RESPONSE: EXCEPTION ERROR - STATUS CODE: ' . $this->statusCode);
            Log::debug('║ (⩾﹏⩽) RESPONSE:  EXCEPTION ERROR - BODY: ' . $result);
        }
        Log::debug('╚════════════════════════════');
    }
}
