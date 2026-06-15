<?php

namespace App\Actions\Tickets;

use App\Enums\TicketStatus;
use App\Models\Responsible;

class AssignTicketAutomaticallyAction
{
    public function execute(): Responsible
    {
        return Responsible::query()
            ->withCount([
                'tickets as open_tickets_count' => function ($query) {
                    $query->whereIn('status', [
                        TicketStatus::OPEN->value,
                        TicketStatus::IN_PROGRESS->value,
                    ]);
                },
            ])
            ->orderBy('open_tickets_count')
            ->orderBy('id')
            ->firstOrFail();
    }
}