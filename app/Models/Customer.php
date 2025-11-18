<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PHPUnit\Framework\Attributes\Ticket;

class Customer extends Model
{
    use HasFactory;
	protected $fillable = [
		'name',
		'phone',
		'email',
	];
	public function tickets(): HasMany
	{
		return $this->hasMany(Ticket::class);
	}

}
