<?php

declare(strict_types=1);

namespace App\Services;

final class EnemApiClient
{
    private ?string $lastError = null;

    public function lastError(): ?string
    {
        return $this->lastError;
    }

    public function listQuestions(int $year, int $limit = 20, int $offset = 0, ?string $language = null): array
    {
        $query = [
            'limit' => max(1, min(50, $limit)),
            'offset' => max(0, $offset),
        ];

        if ($language !== null && $language !== '') {
            $query['language'] = $language;
        }

        $url = ENEM_API_BASE_URL . '/exams/' . $year . '/questions?' . http_build_query($query);
        $payload = $this->request($url);

        if ($payload === null) {
            return ['metadata' => [], 'questions' => []];
        }

        return [
            'metadata' => is_array($payload['metadata'] ?? null) ? $payload['metadata'] : [],
            'questions' => is_array($payload['questions'] ?? null) ? $payload['questions'] : [],
        ];
    }

    private function request(string $url): ?array
    {
        $this->lastError = null;
        $body = null;

        if (function_exists('curl_init')) {
            $curl = curl_init($url);
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTPHEADER => ['Accept: application/json'],
                CURLOPT_USERAGENT => APP_NAME . '/1.0',
            ]);

            $body = curl_exec($curl);
            $status = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($body === false) {
                $this->lastError = curl_error($curl) ?: 'curl_exec retornou false.';
                curl_close($curl);
                return null;
            }

            curl_close($curl);

            if ($status < 200 || $status >= 300) {
                $this->lastError = "HTTP {$status} ao chamar {$url}.";
                return null;
            }
        } else {
            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'timeout' => 10,
                    'header' => "Accept: application/json\r\nUser-Agent: " . APP_NAME . "/1.0\r\n",
                ],
            ]);
            $body = @file_get_contents($url, false, $context);

            if ($body === false) {
                $this->lastError = error_get_last()['message'] ?? "Falha ao chamar {$url}.";
                return null;
            }
        }

        $data = json_decode((string) $body, true);

        if (! is_array($data)) {
            $this->lastError = json_last_error_msg();
            return null;
        }

        return $data;
    }
}
