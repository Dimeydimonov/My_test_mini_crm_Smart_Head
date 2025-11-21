@extends('admin.layout')

@section('title', 'Список заявок')

@section('content')
	<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
		<div class="p-6 bg-white border-b border-gray-200">
			<h2 class="text-2xl font-semibold text-gray-800 mb-6">Список заявок</h2>

			<form method="GET" action="{{ route('admin.tickets.index') }}" class="mb-6">
				<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-2">Статус</label>
						<select name="status" class="w-full border-gray-300 rounded-md shadow-sm">
							<option value="">Все статусы</option>
							<option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Новые</option>
							<option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>В работе</option>
							<option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Обработаны</option>
						</select>
					</div>

					<div>
						<label class="block text-sm font-medium text-gray-700 mb-2">Дата</label>
						<input type="date" name="date" value="{{ request('date') }}"
							   class="w-full border-gray-300 rounded-md shadow-sm">
					</div>

					<div>
						<label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
						<input type="email" name="email" value="{{ request('email') }}"
							   placeholder="email@example.com"
							   class="w-full border-gray-300 rounded-md shadow-sm">
					</div>

					<div>
						<label class="block text-sm font-medium text-gray-700 mb-2">Телефон</label>
						<input type="text" name="phone" value="{{ request('phone') }}"
							   placeholder="+1234567890"
							   class="w-full border-gray-300 rounded-md shadow-sm">
					</div>
				</div>

				<div class="mt-4 flex gap-2">
					<button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
						Применить фильтры
					</button>
					<a href="{{ route('admin.tickets.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
						Сбросить
					</a>
				</div>
			</form>

			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-gray-200">
					<thead class="bg-gray-50">
					<tr>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Клиент</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Тема</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
					</tr>
					</thead>
					<tbody class="bg-white divide-y divide-gray-200">
					@forelse($tickets as $ticket)
						<tr>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
								#{{ $ticket->id }}
							</td>
							<td class="px-6 py-4 whitespace-nowrap">
								<div class="text-sm font-medium text-gray-900">{{ $ticket->customer->name }}</div>
								<div class="text-sm text-gray-500">{{ $ticket->customer->email }}</div>
								<div class="text-sm text-gray-500">{{ $ticket->customer->phone }}</div>
							</td>
							<td class="px-6 py-4">
								<div class="text-sm text-gray-900">{{ Str::limit($ticket->subject, 50) }}</div>
							</td>
							<td class="px-6 py-4 whitespace-nowrap">
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
							</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
								{{ $ticket->created_at->format('d.m.Y H:i') }}
							</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
								<a href="{{ route('admin.tickets.show', $ticket->id) }}"
								   class="text-indigo-600 hover:text-indigo-900">
									Подробнее
								</a>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="6" class="px-6 py-4 text-center text-gray-500">
								Заявки не найдены
							</td>
						</tr>
					@endforelse
					</tbody>
				</table>
			</div>

			<div class="mt-6">
				{{ $tickets->links() }}
			</div>
		</div>
	</div>
@endsection