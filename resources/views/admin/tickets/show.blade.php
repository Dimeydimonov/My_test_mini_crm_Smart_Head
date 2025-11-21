@extends('admin.layout')

@section('title', 'Заявка #' . $ticket->id)

@section('content')
	<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
		<div class="p-6 bg-white border-b border-gray-200">
			<div class="flex justify-between items-center mb-6">
				<h2 class="text-2xl font-semibold text-gray-800">Заявка #{{ $ticket->id }}</h2>
				<a href="{{ route('admin.tickets.index') }}" class="text-indigo-600 hover:text-indigo-900">
					← Назад к списку
				</a>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
				<div class="bg-gray-50 p-4 rounded-lg">
					<h3 class="text-lg font-semibold text-gray-800 mb-3">Клиент</h3>
					<div class="space-y-2">
						<div>
							<span class="text-gray-600">Имя:</span>
							<span class="font-medium">{{ $ticket->customer->name }}</span>
						</div>
						<div>
							<span class="text-gray-600">Email:</span>
							<span class="font-medium">{{ $ticket->customer->email }}</span>
						</div>
						<div>
							<span class="text-gray-600">Телефон:</span>
							<span class="font-medium">{{ $ticket->customer->phone }}</span>
						</div>
					</div>
				</div>

				<div class="bg-gray-50 p-4 rounded-lg">
					<h3 class="text-lg font-semibold text-gray-800 mb-3">Информация</h3>
					<div class="space-y-2">
						<div>
							<span class="text-gray-600">Статус:</span>
							@if($ticket->status === 'new')
								<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Новая
                            </span>
							@elseif($ticket->status === 'in_progress')
								<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                В работе
                            </span>
							@else
								<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Обработана
                            </span>
							@endif
						</div>
						<div>
							<span class="text-gray-600">Создана:</span>
							<span class="font-medium">{{ $ticket->created_at->format('d.m.Y H:i') }}</span>
						</div>
						@if($ticket->manager_response_date)
							<div>
								<span class="text-gray-600">Обработана:</span>
								<span class="font-medium">{{ $ticket->manager_response_date->format('d.m.Y H:i') }}</span>
							</div>
						@endif
					</div>
				</div>
			</div>

			<div class="mb-6">
				<h3 class="text-lg font-semibold text-gray-800 mb-2">Тема</h3>
				<p class="text-gray-700">{{ $ticket->subject }}</p>
			</div>

			<div class="mb-6">
				<h3 class="text-lg font-semibold text-gray-800 mb-2">Сообщение</h3>
				<div class="bg-gray-50 p-4 rounded-lg">
					<p class="text-gray-700 whitespace-pre-wrap">{{ $ticket->message }}</p>
				</div>
			</div>

			@if($ticket->getMedia('ticket_files')->count() > 0)
				<div class="mb-6">
					<h3 class="text-lg font-semibold text-gray-800 mb-3">Прикрепленные файлы ({{ $ticket->getMedia('ticket_files')->count() }})</h3>
					<div class="grid grid-cols-1 md:grid-cols-2 gap-3">
						@foreach($ticket->getMedia('ticket_files') as $media)
							<div class="bg-gray-50 p-3 rounded-lg flex items-center justify-between">
								<div class="flex items-center">
									<svg class="w-8 h-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
									</svg>
									<div>
										<div class="text-sm font-medium text-gray-900">{{ $media->file_name }}</div>
										<div class="text-xs text-gray-500">{{ $media->human_readable_size }}</div>
									</div>
								</div>
								<a href="{{ $media->getUrl() }}"
								   target="_blank"
								   class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
									Скачать
								</a>
							</div>
						@endforeach
					</div>
				</div>
			@endif

			<div class="bg-blue-50 p-4 rounded-lg">
				<h3 class="text-lg font-semibold text-gray-800 mb-3">Изменить статус</h3>
				<form method="POST" action="{{ route('admin.tickets.updateStatus', $ticket->id) }}">
					@csrf
					@method('PATCH')
					<div class="flex gap-3">
						<select name="status" class="flex-1 border-gray-300 rounded-md shadow-sm">
							<option value="new" {{ $ticket->status === 'new' ? 'selected' : '' }}>Новая</option>
							<option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>В работе</option>
							<option value="processed" {{ $ticket->status === 'processed' ? 'selected' : '' }}>Обработана</option>
						</select>
						<button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
							Сохранить
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection