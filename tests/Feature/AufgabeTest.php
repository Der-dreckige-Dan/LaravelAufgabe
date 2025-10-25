<?php

namespace Feature;

use App\Models\Aufgabe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Depends;
use Tests\TestCase;

class AufgabeTest extends TestCase {

    use RefreshDatabase;

    protected string $token;

    protected function setUp(): void {
        parent::setUp();
        $this->seed();
        $response = $this->withBasicAuth('test', '1234')
            ->jsonRoute('GET', 'token.create', apiHeaders: false);
        $response->assertStatus(200);
        $this->token = $response->json();
    }

    private function jsonRoute(string $method, string $name, array $data = [], array $headers = [], bool $apiHeaders = true, array $routeParams = []): TestResponse {
        if ($apiHeaders) {
            $headers = [
                'Authorization' => $this->token,
                'Accept' => 'application/json',
                ...$headers
            ];
        }
        return $this->json($method, route($name, $routeParams), $data, $headers);
    }

    public function testGetCollection(): void {
        $response = $this->jsonRoute('GET', 'aufgaben.index');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $this->assertCount(10, $response->json());
    }

    public function testCreateAufgabe(): void {
        $inputArray = [
            'title' => 'Test aufgabe',
            'description' => 'Test aufgabe',
            'status' => 1,
        ];
        $response = $this->jsonRoute('POST', 'aufgaben.store', $inputArray);
        $response->assertStatus(201);
        $this->assertArrayIsEqualToArrayIgnoringListOfKeys($inputArray, $response->json(), ['id']);
    }

    public function testCreateInvalidAufgabe() {
        $inputArray = [
            'title' => '',
        ];
        $response = $this->jsonRoute('POST', 'aufgaben.store', $inputArray);
        $response->assertStatus(400);
    }

    public function testUpdateAufgabe(): void {
        $aufgabe = Aufgabe::factory()->create([
            'title' => 'Test aufgabe',
            'description' => 'Test aufgabe',
            'status' => 1,
        ]);
        $inputArray = [
            'status' => 2,
        ];
        $response = $this->jsonRoute('PATCH', 'aufgaben.update', $inputArray, routeParams: ['aufgaben' => $aufgabe->id]);
        $response->assertStatus(200);
        $this->assertArrayIsEqualToArrayOnlyConsideringListOfKeys($inputArray, $response->json(), ['status']);
    }

    public function testDeleteAufgabe(): void {
        $aufgabe = Aufgabe::factory()->create([
            'title' => 'Test aufgabe',
            'description' => 'Test aufgabe',
            'status' => 1,
        ]);
        $response = $this->jsonRoute('DELETE', 'aufgaben.destroy', routeParams: ['aufgaben' => $aufgabe->id]);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('aufgaben', ['id' => $aufgabe->id]);
    }
}
