<?php

namespace Tests\Feature;

use App\Enums\TicketStatus;
use App\Models\Responsible;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_displays_ticket_listing_page(): void
    {
        $responsible = Responsible::factory()->create();

        Ticket::factory()->create([
            'title' => 'Computador travando',
            'responsible_id' => $responsible->id,
        ]);

        $response = $this->get(route('tickets.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Tickets/Index')
            ->has('tickets')
            ->has('responsibles')
            ->has('statuses')
            ->has('priorities')
        );
    }

    public function test_it_filters_tickets_by_status(): void
    {
        $responsible = Responsible::factory()->create();

        Ticket::factory()->create([
            'title' => 'Chamado aberto',
            'status' => TicketStatus::OPEN->value,
            'responsible_id' => $responsible->id,
        ]);

        Ticket::factory()->create([
            'title' => 'Chamado fechado',
            'status' => TicketStatus::CLOSED->value,
            'responsible_id' => $responsible->id,
        ]);

        $response = $this->get(route('tickets.index', [
            'status' => TicketStatus::OPEN->value,
        ]));

        $response->assertOk();
    }
}