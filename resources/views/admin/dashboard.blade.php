@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
	<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
		<div class="p-6 bg-white border-b border-gray-200">
			<h2 class="text-2xl font-semibold text-gray-800 mb-6">Статистика заявок</h2>

			<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
				<div class="bg-blue-50 p-6 rounded-lg">
					<h3 class="text-lg font-semibold text-blue-900 mb-4">За сегодня</h3>
					<div class="space-y-2">
						<div class="flex justify-between">
							<span class="text-gray-600">Всего:</span>
							<span class="font-bold text-blue-900">{{ $statsDay['total'] }}</span>
						</div>
						<div class="flex justify-between">
							<span class="text-gray-600">Новые:</span>
							<span class="font-bold text-yellow-600">{{ $statsDay['new'] }}</span>
						</div>
						<div class="flex justify-between">
							<span class="text-gray-600">В работе:</span>
							<span class="font-bold text-orange-600">{{ $statsDay['in_progress'] }}</span>
						</div>
						<div class="flex justify-between">
							<span class="text-gray-600">Обработаны:</span>
							<span class="font-bold text-green-600">{{ $statsDay['processed'] }}</span>
						</div>
					</div>
				</div>

				<div class="bg-purple-50 p-6 rounded-lg">
					<h3 class="text-lg font-semibold text-purple-900 mb-4">За неделю</h3>
					<div class="space-y-2">
						<div class="flex justify-between">
							<span class="text-gray-600">Всего:</span>
							<span class="font-bold text-purple-900">{{ $statsWeek['total'] }}</span>
						</div>
						<div class="flex justify-between">
							<span class="text-gray-600">Новые:</span>
							<span class="font-bold text-yellow-600">{{ $statsWeek['new'] }}</span>
						</div>
						<div class="flex justify-between">
							<span class="text-gray-600">В работе:</span>
							<span class="font-bold text-orange-600">{{ $statsWeek['in_progress'] }}</span>
						</div>
						<div class="flex justify-between">
							<span class="text-gray-600">Обработаны:</span>
							<span class="font-bold text-green-600">{{ $statsWeek['processed'] }}</span>
						</div>
					</div>
				</div>

				<div class="bg-green-50 p-6 rounded-lg">
					<h3 class="text-lg font-semibold text-green-900 mb-4">За месяц</h3>
					<div class="space-y-2">
						<div class="flex justify-between">
							<span class="text-gray-600">Всего:</span>
							<span class="font-bold text-green-900">{{ $statsMonth['total'] }}</span>
						</div>
						<div class="flex justify-between">
							<span class="text-gray-600">Новые:</span>
							<span class="font-bold text-yellow-600">{{ $statsMonth['new'] }}</span>
						</div>
						<div class="flex justify-between">
							<span class="text-gray-600">В работе:</span>
							<span class="font-bold text-orange-600">{{ $statsMonth['in_progress'] }}</span>
						</div>
						<div class="flex justify-between">
							<span class="text-gray-600">Обработаны:</span>
							<span class="font-bold text-green-600">{{ $statsMonth['processed'] }}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection