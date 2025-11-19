<?php
namespace App\Services;

use App\Models\Ticket;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileService
{
	public function attachFiles(Ticket $ticket, array $files): void
	{
		foreach ($files as $file) {
			$ticket->addMedia($file)->toMediaCollection('ticket_files');
		}
	}

	public function  getTicketFiles(Ticket $ticket): array
	{
		return $ticket->getMedia('ticket_files') ->map(function (Media $media) {
			return [
				'id'=>$media ->id,
				'name'=>$media ->file_name,
				'url'=>$media->getUrl(),
				'size'=>$media->human_readable_size,
			];
		})
			->toArray();

	}

}