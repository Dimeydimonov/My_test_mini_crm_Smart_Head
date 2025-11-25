<?php

namespace Tests\Feature\Api;

use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_ticket_via_api(): void
    {
        $response = $this->postJson('/api/tickets', [
            'name' => 'Test User',
            'phone_number' => '+380661638162',
            'email' => 'test@google.com',
            'subject' => 'Test Subject',
            'message' => 'Test message content',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'subject',
                    'message',
                    'status',
                    'customer',
                ],
            ]);

        $this->assertDatabaseHas('tickets', [
            'subject' => 'Test Subject',
            'message' => 'Test message content',
            'status' => 'new',
        ]);

        $this->assertDatabaseHas('customers', [
            'name' => 'Test User',
            'phone_number' => '+380661638162',
            'email' => 'test@google.com',
        ]);
    }

    public function test_cannot_create_ticket_with_invalid_phone_number(): void
    {
        $response = $this->postJson('/api/tickets', [
            'name' => 'Test User',
            'phone_number' => '123456',    // 1-неверный формат
            'email' => 'test@google.com',
            'subject' => 'Test Subject',
            'message' => 'Test message',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['phone_number']);
    }

    public function test_daily_limit_works(): void
    {
        $customer = Customer::factory()->create([
            'phone_number' => '+380661638162',
            'email' => 'test@google.com',
        ]);

        // 2-Создать заявку сегодня
        Ticket::factory()->create([
            'customer_id' => $customer->id,
            'created_at' => now(),
        ]);

        // 3-Попытаться создать еще одну
        $response = $this->postJson('/api/tickets', [
            'name' => $customer->name,
            'phone_number' => $customer->phone_number,
            'email' => $customer->email,
            'subject' => 'Another ticket',
            'message' => 'Test message',
        ]);

        $response->assertStatus(429);
    }

    public function test_can_get_statistics(): void
    {
        Ticket::factory()->count(5)->create(['created_at' => now()]);

        $response = $this->getJson('/api/tickets/statistics?period=day');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'period',
                'data' => [
                    'total',
                    'new',
                    'in_progress',
                    'completed',
                ],
            ]);
    }
}
