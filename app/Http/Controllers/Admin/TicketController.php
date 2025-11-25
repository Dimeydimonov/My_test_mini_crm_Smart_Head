<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TicketService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    private TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    protected array $middleware = ['checkRole:admin,manager'];

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'date', 'email', 'phone']);
        $tickets = $this->ticketService->getTickets($filters);

        return view('admin.tickets.index', compact('tickets', 'filters'));
    }

    public function show(int $id)
    {
        $ticket = $this->ticketService->getTicketWithDetails($id);

        return view('admin.tickets.show', compact('ticket'));
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:new,in_progress,completed',
        ]);

        $this->ticketService->updateStatus($id, $validated['status']);

        return redirect()
            ->route('admin.tickets.show', $id)
            ->with('success', 'Статус заявки успешно обновлен!');
    }
}
