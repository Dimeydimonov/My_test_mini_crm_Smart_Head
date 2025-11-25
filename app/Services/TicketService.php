<?php

namespace App\Services;

use App\Repositories\Contracts\TicketRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TicketService
{
    public function __construct(
        private TicketRepositoryInterface $ticketRepository,
        private CustomerService $customerService,
        private FileService $fileService,
    ) {}

    /**
     * @throws \Throwable
     */
    public function createTicket(array $data, array $files = [])
    {
        return DB::transaction(function () use ($data, $files) {

            $customer = $this->customerService->findOrCreateCustomer([
                'name' => $data['name'],
                'phone_number' => $data['phone_number'],
                'email' => $data['email'],
            ]);

            $ticket = $this->ticketRepository->create([
                'customer_id' => $customer->id,
                'subject' => $data['subject'] ?? null,
                'message' => $data['message'] ?? null,
                'status' => 'new',
            ]);

            if (! empty($files)) {
                $this->fileService->attachFiles($ticket, $files);
            }

            return $ticket->load('customer');
        });
    }

    public function updateStatus(int $ticketId, string $status)
    {
        $data = ['status' => $status];
        if ($status === 'completed') {
            $data['manager_response_date'] = Carbon::now();
        }

        return $this->ticketRepository->update($ticketId, $data);
    }

    public function getTicketWithDetails(int $id)
    {
        return $this->ticketRepository->findById($id);
    }

    public function getStatistics(string $period)
    {
        return $this->ticketRepository->getStatistics($period);
    }

    public function checkDailyLimit(string $phone_number, string $email): bool
    {
        $count = $this->ticketRepository->countTodayByPhoneNumberOrEmail($phone_number, $email);

        // для теста, потом удалить
        logger()->info("Daily limit check: $count tickets found for $phone_number / $email");
        // для теста, потом удалить

        return $count >= 1;

    }

    public function getTickets(array $filters = [])
    {
        return $this->ticketRepository->getAll($filters);
    }
}
