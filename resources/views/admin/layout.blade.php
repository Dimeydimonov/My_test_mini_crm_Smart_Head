<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title', 'Админ-панель') - Mini CRM</title>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
	<nav class="bg-white border-b border-gray-200">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex justify-between h-16">
				<div class="flex">
					<div class="flex-shrink-0 flex items-center">
						<h1 class="text-xl font-bold text-gray-800">Mini CRM</h1>
					</div>
					<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
						<a href="{{ route('admin.dashboard') }}"
						   class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-indigo-500' : 'border-transparent' }} text-sm font-medium text-gray-900">
							Dashboard
						</a>
						<a href="{{ route('admin.tickets.index') }}"
						   class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.tickets.*') ? 'border-indigo-500' : 'border-transparent' }} text-sm font-medium text-gray-900">
							Заявки
						</a>
					</div>
				</div>
				<div class="flex items-center">
					<span class="text-gray-700 mr-4">{{ Auth::user()->name }}</span>
					<form method="POST" action="{{ route('logout') }}">
						@csrf
						<button type="submit" class="text-sm text-gray-600 hover:text-gray-900">
							Выйти
						</button>
					</form>
				</div>
			</div>
		</div>
	</nav>

	<main class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			@if(session('success'))
				<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
					{{ session('success') }}
				</div>
			@endif

			@yield('content')
		</div>
	</main>
</div>
</body>
</html>