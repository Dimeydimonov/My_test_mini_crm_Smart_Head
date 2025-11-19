<?php
namespace App\Repositories\Contracts;
interface CustomerRepositoryInterface
{
	public function findByPhoneNumber(string $phone_number);
	public function findByEmail(string $email);
	public function create(array $data);
	public function findOrCreate(array $data);
}