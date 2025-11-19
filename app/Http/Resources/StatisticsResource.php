<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatisticsResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
			'total' => $this->resource ['total'],
	        'new' => $this->resource ['new'],
	        'in_progress' => $this->resource ['in_progress'],
	        'processed' => $this->resource ['processed'],
        ];

    }
}
