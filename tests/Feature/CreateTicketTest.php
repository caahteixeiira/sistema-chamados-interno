<?php

namespace Tests\Feature;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Responsible;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_ticket_with_manual_responsible(): void
    {
        $responsible = Responsible::factory()->create();

        $response = $this->post(route('tickets.store'), [
            'title' => 'Computador travando',
            'description' => 'O computador do setor financeiro está travando.',
            'priority' => TicketPriority::HIGH->value,
            'status' => TicketStatus::OPEN->value,
            'responsible_id' => $responsible->id,
            'assign_automatically' => false,
        ]);

        $response->assertRedirect(route('tickets.index'));

        $this->assertDatabaseHas('tickets', [
            'title' => 'Computador travando',
            'priority' => TicketPriority::HIGH->value,
            'status' => TicketStatus::OPEN->value,
            'responsible_id' => $responsible->id,
        ]);
    }
}