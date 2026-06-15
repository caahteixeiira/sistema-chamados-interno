<?php

namespace Tests\Feature;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Responsible;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_a_ticket(): void
    {
        $responsible = Responsible::factory()->create();

        $ticket = Ticket::factory()->create([
            'responsible_id' => $responsible->id,
            'status' => TicketStatus::OPEN->value,
        ]);

        $response = $this->put(route('tickets.update', $ticket), [
            'title' => 'Cadeira quebrada',
            'description' => 'A cadeira do setor administrativo está quebrada.',
            'priority' => TicketPriority::LOW->value,
            'status' => TicketStatus::IN_PROGRESS->value,
            'responsible_id' => $responsible->id,
            'assign_automatically' => false,
        ]);

        $response->assertRedirect(route('tickets.show', $ticket));

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'title' => 'Cadeira quebrada',
            'status' => TicketStatus::IN_PROGRESS->value,
            'priority' => TicketPriority::LOW->value,
        ]);
    }
}