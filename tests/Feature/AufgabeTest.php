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

    private function getJsonFromResponse(TestResponse $response): mixed {
        if (!empty($response->json('data'))) {
            return $response->json('data');
        }
        return $response->json();
    }

    public function testGetCollection(): void {
        $response = $this->jsonRoute('GET', 'aufgaben.index');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $this->assertCount(10, $this->getJsonFromResponse($response));
    }

    public function testCreateAufgabe(): void {
        $inputArray = [
            'title' => 'Test aufgabe',
            'description' => 'Test aufgabe',
            'status' => 1,
            'deadline' => now()->toDateTimeString(),
            'user_id' => 1,
            'projekt_id' => 2,
        ];
        $response = $this->jsonRoute('POST', 'aufgaben.store', $inputArray);
        $response->assertStatus(201);
        $this->assertArrayIsEqualToArrayIgnoringListOfKeys($inputArray, $this->getJsonFromResponse($response), ['id']);
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
            'projekt_id' => 1,
            'user_id' => 1,
        ]);
        $inputArray = [
            'status' => 2,
        ];
        $response = $this->jsonRoute('PATCH', 'aufgaben.update', $inputArray, routeParams: ['aufgaben' => $aufgabe->id]);
        $response->assertStatus(200);
        $this->assertArrayIsEqualToArrayOnlyConsideringListOfKeys($inputArray, $this->getJsonFromResponse($response), ['status']);
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

    public function testUserAufgaben(): void {
        Aufgabe::factory()->create([
            'user_id' => 1
        ]);
        $response = $this->jsonRoute('GET', 'user.aufgaben', routeParams: ['user' => 1]);
        $response->assertStatus(200);
        $this->assertNotEmpty($this->getJsonFromResponse($response));

    }

    public function testProjektAufgaben(): void {
        Aufgabe::factory()->create([
            'projekt_id' => 1
        ]);
        $response = $this->jsonRoute('GET', 'projekte.aufgaben', routeParams: ['projekt' => 1]);
        $response->assertStatus(200);
        $this->assertNotEmpty($this->getJsonFromResponse($response));
    }

    public function testAufgabenOverdue(): void {
        $response = $this->jsonRoute('GET', 'aufgaben.overdue');
        $response->assertStatus(200);
    }

    public function testUpdateDeadline(): void {
        $aufgabe = Aufgabe::factory()->create([
            'title' => 'Test aufgabe',
            'description' => 'Test aufgabe',
            'status' => 1,
            'user_id' => 1,
        ]);
        $inputArray = [
            'deadline' => now()->toDateTimeString(),
        ];
        $response = $this->jsonRoute('PATCH', 'aufgaben.update', $inputArray, routeParams: ['aufgaben' => $aufgabe->id]);
        $response->assertStatus(200);
        $this->assertArrayIsEqualToArrayOnlyConsideringListOfKeys($inputArray, $this->getJsonFromResponse($response), ['deadline']);
    }

    public function testNotification() {
        $aufgabe = Aufgabe::factory()->create([
            'user_id' => 1,
        ]);
        $response = $this->jsonRoute('PUT', 'aufgaben.update', routeParams: ['aufgaben' => $aufgabe->id]);
        $response->assertStatus(200);
        $this->assertArrayHasKey('notifications', $response->json());
        $this->assertNotEmpty($response->json()['notifications']);
    }
}
