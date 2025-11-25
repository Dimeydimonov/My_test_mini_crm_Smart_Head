<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\StatisticsResource;
use App\Http\Resources\TicketResource;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct(
        private TicketService $ticketService
    ) {}

    public function store(StoreTicketRequest $request): JsonResponse
    {
        if ($this->ticketService->checkDailyLimit($request->phone_number, $request->email)) {
            return response()->json([
                'message' => 'Вы сегодня создавали заявку. Попробуйте завтра.',
            ], 429);
        }

        $data = $request->validated();
        $files = $request->hasFile('files') ? $request->file('files') : [];

        $ticket = $this->ticketService->createTicket($data, $files);

        return response()->json([
            'message' => ' Заявка успешно создана',
            'data' => new TicketResource($ticket),
        ], 201);
    }

    public function statistics(Request $request): JsonResponse
    {
        $period = $request->query('period', 'day');
        if (! in_array($period, ['day', 'week', 'month'])) {
            return response()->json([
                'message' => 'Неверный период. Используйте: day, week, month',
            ], 400);
        }
        $statistics = $this->ticketService->getStatistics($period);

        return response()->json([
            'period' => $period,
            'data' => new StatisticsResource($statistics),
        ]);
    }
}
