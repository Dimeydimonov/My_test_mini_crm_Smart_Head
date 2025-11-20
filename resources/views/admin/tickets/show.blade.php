@extends('admin.layout')

@section('title', 'Заявка #' . $ticket->id)

@section('content')
	<div class="admin-card">
		<div class="admin-card-body">
			<div class="ticket-header">
				<h2 class="ticket-title">Заявка #{{ $ticket->id }}</h2>
				<a href="{{ route('admin.tickets.index') }}" class="back-link">
					← Назад к списку
				</a>
			</div>

			<div class="detail-grid">
				<div class="detail-card">
					<h3 class="detail-card-title">Клиент</h3>
					<div>
						<div class="detail-row">
							<span class="detail-label">Имя:</span>
							<span class="detail-value">
								{{ $ticket->customer->name }}
							</span>
						</div>
						<div class="detail-row">
							<span class="detail-label">Email:</span>
							<span class="detail-value">
								{{ $ticket->customer->email }}
							</span>
						</div>
						<div class="detail-row">
							<span class="detail-label">Телефон:</span>
							<span class="detail-value">
								{{ $ticket->customer->phone }}
							</span>
						</div>
					</div>
				</div>

				<div class="detail-card">
					<h3 class="detail-card-title">Информация</h3>
					<div>
						<div class="detail-row">
							<span class="detail-label">Статус:</span>
							@if($ticket->status === 'new')
								<span class="status-badge new">Новая</span>
							@elseif($ticket->status === 'in_progress')
								<span class="status-badge in-progress">В работе</span>
							@else
								<span class="status-badge completed">Обработана</span>
							@endif
						</div>
						<div class="detail-row">
							<span class="detail-label">Создана:</span>
							<span class="detail-value">
								{{ $ticket->created_at->format('d.m.Y H:i') }}
							</span>
						</div>
						@if($ticket->manager_response_date)
							<div class="detail-row">
								<span class="detail-label">Обработана:</span>
								<span class="detail-value">
									{{ $ticket->manager_response_date->format('d.m.Y H:i') }}
								</span>
							</div>
						@endif
					</div>
				</div>
			</div>

			<div class="content-section">
				<h3 class="section-title">Тема</h3>
				<p class="section-text">{{ $ticket->subject }}</p>
			</div>

			<div class="content-section">
				<h3 class="section-title">Сообщение</h3>
				<div class="section-content">
					<p class="section-message">{{ $ticket->message }}</p>
				</div>
			</div>

			@if($ticket->getMedia('ticket_files')->count() > 0)
				<div class="content-section">
					<h3 class="section-title">
						Прикрепленные файлы ({{ $ticket->getMedia('ticket_files')->count() }})
					</h3>
					<div class="files-grid">
						@foreach($ticket->getMedia('ticket_files') as $media)
							<div class="file-item">
								<div class="file-info">
									<div class="file-details">
										<div class="file-name">{{ $media->file_name }}</div>
										<div class="file-size">{{ $media->human_readable_size }}</div>
									</div>
								</div>
								<a href="{{ $media->getUrl() }}" target="_blank" download class="file-download">
									Скачать
								</a>
							</div>
						@endforeach
					</div>
				</div>
			@endif

			<div class="status-form">
				<h3 class="status-form-title">Изменить статус</h3>
				<form method="POST" action="{{ route('admin.tickets.updateStatus', $ticket->id) }}">
					@csrf
					@method('PATCH')
					<div class="status-form-content">
						<select name="status">
							<option value="new" {{ $ticket->status === 'new' ? 'selected' : '' }}>Новая</option>
							<option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>В работе</option>
							<option value="completed" {{ $ticket->status === 'completed' ? 'selected' : '' }}>Обработана</option>
						</select>
						<button type="submit">Сохранить</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection