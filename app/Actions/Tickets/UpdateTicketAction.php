<?php

namespace App\Actions\Tickets;

use App\Models\Ticket;

class UpdateTicketAction
{
    public function __construct(
        private readonly AssignTicketAutomaticallyAction $assignTicketAutomaticallyAction
    ) {}

    public function execute(Ticket $ticket, array $data): Ticket
    {
        $responsibleId = $data['responsible_id'] ?? $ticket->responsible_id;

        if (! empty($data['assign_automatically'])) {
            $responsibleId = $this->assignTicketAutomaticallyAction
                ->execute()
                ->id;
        }

        $ticket->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'priority' => $data['priority'],
            'status' => $data['status'],
            'responsible_id' => $responsibleId,
        ]);

        return $ticket->fresh('responsible');
    }
}