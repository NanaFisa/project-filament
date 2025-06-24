<?php
namespace App\Service;

use Illuminate\Support\Facades\Http;

class GraphQLService {
    protected string $endpoint;

    public function __construct() {
        $this->endpoint = config('services.grapghql.url');
    }

    public function query(string $query, array $variables = []) {
        $response = Http::post($this->endpoint, [
            'query' => $query,
            'variables' => $variables,
            ]);

        return $response->json('data');
    }

    public function mutation(string $mutation, array $variables = []) {
        $response = Http::post($this->endpoint, [
            'query' => $mutation,
            'variables' => $variables,
            ]);
        return $response->json('data');
    }
}
