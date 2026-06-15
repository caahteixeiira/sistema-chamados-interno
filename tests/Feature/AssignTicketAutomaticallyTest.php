<?php

namespace Tests\Feature;

use App\Actions\Tickets\AssignTicketAutomaticallyAction;
use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Responsible;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssignTicketAutomaticallyTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_assigns_ticket_to_responsible_with_less_open_tickets(): void
    {
        $ana = Responsible::factory()->create(['name' => 'Ana']);
        $bruno = Responsible::factory()->create(['name' => 'Bruno']);
        $carla = Responsible::factory()->create(['name' => 'Carla']);

        Ticket::factory()->count(2)->create([
            'responsible_id' => $ana->id,
            'status' => TicketStatus::OPEN->value,
        ]);

        Ticket::factory()->create([
            'responsible_id' => $bruno->id,
            'status' => TicketStatus::IN_PROGRESS->value,
        ]);

        $responsible = app(AssignTicketAutomaticallyAction::class)->execute();

        $this->assertTrue($responsible->is($carla));
    }

    public function test_it_does_not_count_resolved_or_closed_tickets_as_open(): void
    {
        $ana = Responsible::factory()->create(['name' => 'Ana']);
        $bruno = Responsible::factory()->create(['name' => 'Bruno']);

        Ticket::factory()->count(3)->create([
            'responsible_id' => $ana->id,
            'status' => TicketStatus::RESOLVED->value,
        ]);

        Ticket::factory()->create([
            'responsible_id' => $bruno->id,
            'status' => TicketStatus::OPEN->value,
        ]);

        $responsible = app(AssignTicketAutomaticallyAction::class)->execute();

        $this->assertTrue($responsible->is($ana));
    }

    public function test_it_creates_ticket_with_automatic_responsible(): void
    {
        $responsible = Responsible::factory()->create();

        $response = $this->post(route('tickets.store'), [
            'title' => 'Impressora não funciona',
            'description' => 'A impressora do administrativo não está imprimindo.',
            'priority' => TicketPriority::MEDIUM->value,
            'status' => TicketStatus::OPEN->value,
            'responsible_id' => null,
            'assign_automatically' => true,
        ]);

        $response->assertRedirect(route('tickets.index'));

        $this->assertDatabaseHas('tickets', [
            'title' => 'Impressora não funciona',
            'responsible_id' => $responsible->id,
        ]);
    }
}