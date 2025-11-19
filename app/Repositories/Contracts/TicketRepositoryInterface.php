<?php
namespace App\Repositories\Contracts;
interface TicketRepositoryInterface
{
	public function create(array $data);
	public function  update(int $id, array $data);
	public function findById(int $id);
	public function getAll(array $filters = []);
	public function getStatistics(string $period);
	public function countTodayByPhoneNumberOrEmail(string $phone_number, string $email): int;
}