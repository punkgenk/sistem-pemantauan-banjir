<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class ChatbotTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'masyarakat']);
    }

    /** @test */
    public function chatbot_menolak_request_tanpa_login()
    {
        $response = $this->postJson('/chatbot/ask', [
            'message' => 'Apa yang harus dilakukan saat banjir?'
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function chatbot_menolak_pesan_kosong()
    {
        $response = $this->actingAs($this->user)
            ->postJson('/chatbot/ask', ['message' => '']);

        $response->assertStatus(422);
    }

    /** @test */
    public function chatbot_menolak_pesan_terlalu_panjang()
    {
        $response = $this->actingAs($this->user)
            ->postJson('/chatbot/ask', [
                'message' => str_repeat('a', 501)
            ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function chatbot_mengembalikan_reply_saat_api_sukses()
    {
        Http::fake([
            'api.groq.com/*' => Http::response([
                'choices' => [
                    ['message' => ['content' => 'Segera evakuasi ke tempat yang lebih tinggi.']]
                ]
            ], 200)
        ]);

        $response = $this->actingAs($this->user)
            ->postJson('/chatbot/ask', [
                'message' => 'Apa yang harus dilakukan saat banjir?'
            ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['reply'])
                 ->assertJson(['reply' => 'Segera evakuasi ke tempat yang lebih tinggi.']);
    }

    /** @test */
    public function chatbot_mengembalikan_pesan_fallback_saat_api_gagal()
    {
        Http::fake([
            'api.groq.com/*' => Http::response([], 500)
        ]);

        $response = $this->actingAs($this->user)
            ->postJson('/chatbot/ask', [
                'message' => 'Apa yang harus dilakukan saat banjir?'
            ]);

        $response->assertStatus(200)
                 ->assertJson(['reply' => 'Maaf, chatbot tidak dapat menjawab saat ini.']);
    }
}