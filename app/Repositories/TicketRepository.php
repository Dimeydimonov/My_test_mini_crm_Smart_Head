<?php
namespace App\Repositories;

use App\Models\Ticket;
use App\Repositories\Contracts\TicketRepositoryInterface;
use Carbon\Carbon;
class TicketRepository implements TicketRepositoryInterface
{
	public function create(array $data)
	{
		return Ticket::create($data);
	}
	public function update (int $id, array $data)
	{
	$ticket = Ticket::findOrFail($id);
	$ticket->update($data);
	return $ticket->fresh();
	}
	public function findById(int $id)
	{
		return Ticket::with(['customer' , 'media'])->findOrFail($id);
	}
	public function getAll(array $filters = [])
	{
		$query = Ticket::with('customer');
		if(!empty($filters['status'])) {
			$query->where('status', $filters['status']);
		}
		if(!empty($filters['date'])) {
			$query->whereDate('created_at' , $filters['date']);
		}
		if(!empty($filters['email'])) {
			$query->whereHas('customer', function ($q) use ($filters) {
				$q->where('email', 'like', '%' . $filters['email'] . '%');
			});
		}
		if(!empty($filters['phone_number']))
		{
			$query->whereHas('customer', function ($q) use ($filters) {
				$q->where('phone_number', 'like', '%' . $filters['phone_number'] . '%');
			});
		}
		return $query->latest()->paginate(20);
	}
	public function getStatics(string$period)
	{
		$query = Ticket::query();
		switch ($period) {
			case 'day':
				$query->today();
				break;
				case 'week':
					$query->week();
					break;
					case 'month':
						$query->month();
						break;
		}
		return[
			'total' => $query->count(),
			'new'=> (clone $query)->where('status', 'new')->count(),
			'in_progress'=> (clone $query)->where('status', 'in_progress')->count(),
			'progressed'=> (clone $query)->where('status', 'progress')->count(),

		];

	}
	public  function countTodayByPhoneNumberOrEmail( string$phone_number, string $email): int
	{
		return  Ticket::whereHas('customer', function ($query) use ($phone_number, $email) {
			$query->where('phone_number', $phone_number)
				->where('email', $email);
		})
			->whereDate('created_at' , Carbon::today())
			->count();


	}

	public function getStatistics(string $period)
	{
		// TODO: Implement getStatistics() method.
	}
}