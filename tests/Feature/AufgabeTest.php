<?php

namespace Feature;

use ApiPlatform\Laravel\Test\ApiTestAssertionsTrait;
use App\Models\Aufgabe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Depends;
use Tests\TestCase;

class AufgabeTest extends TestCase {

    use RefreshDatabase, ApiTestAssertionsTrait;

    protected string $token;

    protected function setUp(): void {
        parent::setUp();
        $this->seed();
        $response = $this->withBasicAuth('test', '1234')
            ->getJson('/user/token/1');
        $response->assertStatus(200);
        $this->token = $response->json('token');
    }

    public function testGetCollection(): void {
        $response = $this->getJson('/api/aufgaben', [
            'Authorization' => $this->token,
            'Accept' => 'application/json',
        ]);
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json; charset=utf-8');
        $this->assertCount(10, $response->json());
    }

    public function testCreateAufgabe(): void {
        $response = $this->postJson('/api/aufgaben', [
            'title' => 'Test aufgabe',
            'description' => 'Test aufgabe',
            'status' => '1',
        ], [
            'Authorization' => $this->token,
            'Accept' => 'application/json',
        ]);
        $response->assertStatus(201);
    }

    public function testCreateInvalidAufgabe() {
        $response = $this->postJson('/api/aufgaben', [
            'title' => 'Test aufgabe',
            'description' => 'Test aufgabe',
            'status' => '1',
        ], [
            'Authorization' => $this->token,
            'Accept' => 'application/json',
        ]);
        $response->assertStatus(422);
    }

    public function testUpdateAufgabe(): void {
        $aufgabe = Aufgabe::factory()->create([
            'title' => 'Test aufgabe',
            'description' => 'Test aufgabe',
            'status' => '1',
        ]);
        $response = $this->putJson($this->getIriFromResource($aufgabe), [
            'status' => '2',
        ], [
            'Authorization' => $this->token,
            'Accept' => 'application/json',
        ]);
        $response->assertStatus(200);
        $this->assertJsonContains([
            'status' => '2'
        ], $response->json());
    }

    public function testDeleteAufgabe(): void {
        $aufgabe = Aufgabe::factory()->create([
            'title' => 'Test aufgabe',
            'description' => 'Test aufgabe',
            'status' => '1',
        ]);
        $response = $this->deleteJson($this->getIriFromResource($aufgabe), [
            'Authorization' => $this->token,
            'Accept' => 'application/json',
        ]);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('aufgaben', ['id' => $aufgabe->id]);
    }
}
