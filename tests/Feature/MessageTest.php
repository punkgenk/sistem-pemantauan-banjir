<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Conversation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_send_text_message()
    {
        $masyarakat = User::factory()->create(['role' => 'masyarakat']);
        $pemerintah = User::factory()->create(['role' => 'pemerintah']);

        $conversation = Conversation::create([
            'masyarakat_id' => $masyarakat->id,
            'pemerintah_id' => $pemerintah->id,
        ]);

        $this->actingAs($masyarakat)
            ->post(route('chat.store', $conversation), [
                'message' => 'Mohon segera ditindaklanjuti, air semakin tinggi'
            ]);

        $this->assertDatabaseHas('messages', [
            'message' => 'Mohon segera ditindaklanjuti, air semakin tinggi'
        ]);
    }
}
