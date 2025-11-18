<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends Model implements HasMedia
{
	use HasFactory, InteractsWithMedia;
	protected $fillable = [
	'customer_id',
	'subject',
	'message',
	'status',
	'manager_response_date',
	];
	protected $casts =  [
		'manager_response_date' => 'datetime',
	];
	public function customer(): BelongsTo
	{
		return $this->belongsTo(Customer::class);
	}

	public function scopeToday($query)
	{
		return $query->whereDate('created_at', Carbon::today());
	}

	public function scopeLastWeek($query){
		return $query->whenBetween('created_at', [
			Carbon::now()->subWeek(),
			Carbon::now(),
		]);
	}
     public function scopeLastMonth($query){
		return $query->whenBetween('created_at', [
			Carbon::now()->subMonth(),
			Carbon::now(),
		]);
     }
}
