@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
	<div class="admin-card">
		<div class="admin-card-header">
			<h2 class="admin-card-title">Статистика заявок</h2>
		</div>
		<div class="admin-card-body">
			<div class="stats-grid">
				<div class="stat-card blue">
					<h3 class="stat-card-title">За сегодня</h3>
					<div>
						<div class="stat-row">
							<span class="stat-label">Всего:</span>
							<span class="stat-value">{{ $statsDay['total'] }}</span>
						</div>
						<div class="stat-row">
							<span class="stat-label">Новые:</span>
							<span class="stat-value stat-value-warning">{{ $statsDay['new'] }}</span>
						</div>
						<div class="stat-row">
							<span class="stat-label">В работе:</span>
							<span class="stat-value stat-value-danger">{{ $statsDay['in_progress'] }}</span>
						</div>
						<div class="stat-row">
							<span class="stat-label">Обработаны:</span>
							<span class="stat-value stat-value-success">{{ $statsDay['completed'] }}</span>
						</div>
					</div>
				</div>

				<div class="stat-card purple">
					<h3 class="stat-card-title">За неделю</h3>
					<div>
						<div class="stat-row">
							<span class="stat-label">Всего:</span>
							<span class="stat-value">{{ $statsWeek['total'] }}</span>
						</div>
						<div class="stat-row">
							<span class="stat-label">Новые:</span>
							<span class="stat-value stat-value-warning">{{ $statsWeek['new'] }}</span>
						</div>
						<div class="stat-row">
							<span class="stat-label">В работе:</span>
							<span class="stat-value stat-value-danger">{{ $statsWeek['in_progress'] }}</span>
						</div>
						<div class="stat-row">
							<span class="stat-label">Обработаны:</span>
							<span class="stat-value stat-value-success">{{ $statsWeek['completed'] }}</span>
						</div>
					</div>
				</div>

				<div class="stat-card green">
					<h3 class="stat-card-title">За месяц</h3>
					<div>
						<div class="stat-row">
							<span class="stat-label">Всего:</span>
							<span class="stat-value">{{ $statsMonth['total'] }}</span>
						</div>
						<div class="stat-row">
							<span class="stat-label">Новые:</span>
							<span class="stat-value stat-value-warning">{{ $statsMonth['new'] }}</span>
						</div>
						<div class="stat-row">
							<span class="stat-label">В работе:</span>
							<span class="stat-value stat-value-danger">{{ $statsMonth['in_progress'] }}</span>
						</div>
						<div class="stat-row">
							<span class="stat-label">Обработаны:</span>
							<span class="stat-value stat-value-success">{{ $statsMonth['completed'] }}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection