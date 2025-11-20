<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title', 'Админ-панель') - Mini CRM</title>
	<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<nav class="admin-nav">
	<div class="admin-nav-container">
		<div class="admin-nav-content">
			<div class="admin-nav-left">
				<h1 class="admin-logo">Mini CRM</h1>
				<ul class="admin-menu">
					<li>
						<a href="{{ route('admin.dashboard') }}"
						   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
							Dashboard
						</a>
					</li>
					<li>
						<a href="{{ route('admin.tickets.index') }}"
						   class="{{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
							Заявки
						</a>
					</li>
				</ul>
			</div>
			<div class="admin-user-section">
				<span class="admin-username">{{ Auth::user()->name }}</span>
				<form method="POST" action="{{ route('logout') }}">
					@csrf
					<button type="submit" class="admin-logout-btn">
						Выйти
					</button>
				</form>
			</div>
		</div>
	</div>
</nav>

<main class="admin-main">
	<div class="admin-container">
		@if(session('success'))
			<div class="admin-alert admin-alert-success">
				{{ session('success') }}
			</div>
		@endif

		@yield('content')
	</div>
</main>
</body>
</html>