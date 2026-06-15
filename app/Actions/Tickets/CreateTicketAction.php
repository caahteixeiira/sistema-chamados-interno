<?php

namespace App\Actions\Tickets;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use Illuminate\Support\Carbon;

class CreateTicketAction
{
    public function __construct(
        private readonly AssignTicketAutomaticallyAction $assignTicketAutomaticallyAction
    ) {}

    public function execute(array $data): Ticket
    {
        $responsibleId = $data['responsible_id'] ?? null;

        if (! empty($data['assign_automatically'])) {
            $responsibleId = $this->assignTicketAutomaticallyAction
                ->execute()
                ->id;
        }

        return Ticket::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'priority' => $data['priority'],
            'status' => $data['status'] ?? TicketStatus::OPEN->value,
            'responsible_id' => $responsibleId,
            'opened_at' => Carbon::now(),
        ]);
    }
}