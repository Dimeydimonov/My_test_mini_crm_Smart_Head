<?php

	namespace App\Http\Controllers\Admin;

	use App\Http\Controllers\Controller;
	use App\Services\TicketService;
	use Illuminate\Http\Request;

	class DashboardController extends Controller
	{
		public function __construct(
			private readonly TicketService $ticketService
		) {}

		public function index()
		{
			$statsDay = $this->ticketService->getStatistics('day');
			$statsWeek = $this->ticketService->getStatistics('week');
			$statsMonth = $this->ticketService->getStatistics('month');

			return view('admin.dashboard', compact('statsDay', 'statsWeek', 'statsMonth'));
		}
	}