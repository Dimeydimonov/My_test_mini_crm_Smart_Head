<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,
            'subject' => $this->subject,
            'message' => $this->message,
            'status' => $this->status,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'files' => $this->when($this->relationLoaded('media'), function () {
                return $this->getMedia('ticket_files')->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'name' => $media->file_name,
                        'url' => $media->getUrl(),
                        'size' => $media->human_readable_size,

                    ];
                });
            }),

            'manager_response_date' => $this->manager_response_date?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),

        ];
    }
}
