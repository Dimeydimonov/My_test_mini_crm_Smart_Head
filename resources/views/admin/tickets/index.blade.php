@extends('admin.layout')

@section('title', 'Список заявок')

@section('content')
	<div class="admin-card">
		<div class="admin-card-header">
			<h2 class="admin-card-title">Список заявок</h2>
		</div>
		<div class="admin-card-body">
			<form method="GET" action="{{ route('admin.tickets.index') }}" class="filters-form">
				<div class="filters-grid">
					<div class="filter-group">
						<label for="status">Статус</label>
						<select name="status" id="status">
							<option value="">Все статусы</option>
							<option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>Новые</option>
							<option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>В
								работе
							</option>
							<option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>
								Обработаны
							</option>
						</select>
					</div>

					<div class="filter-group">
						<label for="date">Дата</label>
						<input type="date" name="date" id="date" value="{{ request('date') }}">
					</div>

					<div class="filter-group">
						<label for="email">Email</label>
						<input type="email" name="email" id="email" value="{{ request('email') }}"
							   placeholder="email@example.com">
					</div>

					<div class="filter-group">
						<label for="phone">Телефон</label>
						<input type="text" name="phone" id="phone" value="{{ request('phone') }}"
							   placeholder="+1234567890">
					</div>
				</div>

				<div class="filters-buttons">
					<button type="submit" class="btn btn-primary">
						Применить фильтры
					</button>
					<a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">
						Сбросить
					</a>
				</div>
			</form>

			<div class="table-wrapper">
				<table class="admin-table">
					<thead>
					<tr>
						<th>ID</th>
						<th>Клиент</th>
						<th>Тема</th>
						<th>Статус</th>
						<th>Дата</th>
						<th>Действия</th>
					</tr>
					</thead>
					<tbody>
					@forelse($tickets as $ticket)
						<tr>
							<td>#{{ $ticket->id }}</td>
							<td>
								<div class="customer-info">
									<div class="customer-name">{{ $ticket->customer->name }}</div>
									<div class="customer-detail">{{ $ticket->customer->email }}</div>
									<div class="customer-detail">{{ $ticket->customer->phone }}</div>
								</div>
							</td>
							<td>{{ Str::limit($ticket->subject, 50) }}</td>
							<td>
								@if($ticket->status === 'new')
									<span class="status-badge new">Новая</span>
								@elseif($ticket->status === 'in_progress')
									<span class="status-badge in-progress">В работе</span>
								@else
									<span class="status-badge processed">Обработана</span>
								@endif
							</td>
							<td>{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
							<td>
								<a href="{{ route('admin.tickets.show', $ticket->id) }}" class="table-link">
									Подробнее
								</a>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="6" class="text-center text-gray">
								Заявки не найдены
							</td>
						</tr>
					@endforelse
					</tbody>
				</table>
			</div>

			<div class="pagination-wrapper">
				{{ $tickets->links() }}
			</div>
		</div>
	</div>
@endsection