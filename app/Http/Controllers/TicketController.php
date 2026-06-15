<?php

namespace App\Http\Controllers;

use App\Actions\Tickets\CreateTicketAction;
use App\Actions\Tickets\UpdateTicketAction;
use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Responsible;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TicketController extends Controller
{
    public function index(Request $request): Response
    {
        $tickets = Ticket::query()
    ->select([
        'id',
        'title',
        'priority',
        'status',
        'responsible_id',
        'opened_at',
    ])
            ->with('responsible:id,name')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('priority'), function ($query) use ($request) {
                $query->where('priority', $request->priority);
            })
            ->when($request->filled('responsible_id'), function ($query) use ($request) {
                $query->where('responsible_id', $request->responsible_id);
            })
            ->latest('opened_at')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Tickets/Index', [
            'tickets' => $tickets,
            'filters' => $request->only([
                'search',
                'status',
                'priority',
                'responsible_id',
            ]),
            'responsibles' => Responsible::orderBy('name')->get(),
            'statuses' => $this->statuses(),
'priorities' => $this->priorities(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Tickets/Create', [
            'responsibles' => Responsible::orderBy('name')->get(),
            'statuses' => $this->statuses(),
            'priorities' => $this->priorities(),
        ]);
    }

   public function store(
    StoreTicketRequest $request,
    CreateTicketAction $createTicketAction
): RedirectResponse {
    $createTicketAction->execute($request->validated());

    return redirect()
        ->route('tickets.index')
        ->with('success', 'Chamado criado com sucesso.');
}

    public function show(Ticket $ticket): Response
    {
        return Inertia::render('Tickets/Show', [
            'ticket' => $ticket->load('responsible'),
        ]);
    }

    public function edit(Ticket $ticket): Response
    {
        return Inertia::render('Tickets/Edit', [
            'ticket' => $ticket->load('responsible'),
            'responsibles' => Responsible::orderBy('name')->get(),
            'statuses' => $this->statuses(),
            'priorities' => $this->priorities(),
        ]);
    }

    public function update(
        UpdateTicketRequest $request,
        Ticket $ticket,
        UpdateTicketAction $updateTicketAction
    ): RedirectResponse {
        $updateTicketAction->execute($ticket, $request->validated());

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Chamado atualizado com sucesso.');
    }

    public function destroy(Ticket $ticket): RedirectResponse
    {
        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Chamado removido com sucesso.');
    }

private function statuses(): array
{
    return collect(TicketStatus::cases())
        ->map(fn (TicketStatus $status) => [
            'value' => $status->value,
            'label' => $status->label(),
        ])
        ->toArray();
}

private function priorities(): array
{
    return collect(TicketPriority::cases())
        ->map(fn (TicketPriority $priority) => [
            'value' => $priority->value,
            'label' => $priority->label(),
        ])
        ->toArray();
}
}