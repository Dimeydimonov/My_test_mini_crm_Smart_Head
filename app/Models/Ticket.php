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

		protected $casts = [
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

		public function scopeWeek($query)
		{
			return $query->whereBetween('created_at', [
				Carbon::now()->startOfWeek(),
				Carbon::now()->endOfWeek(),
			]);
		}

		public function scopeMonth($query)
		{
			return $query->whereMonth('created_at', Carbon::now()->month)
				->whereYear('created_at', Carbon::now()->year);
		}
	}
