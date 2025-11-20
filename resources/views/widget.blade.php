<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Форма обратной связи</title>
	<link rel="stylesheet" href="{{ asset('css/widget.css') }}">
</head>
<body>
<div class="widget-container">
	<h2>   Форма обратной связи</h2>

	<div id="message" class="message"></div>

	<form id="ticketForm">
		<div class="form-group">
			<label for="name">Имя *</label>
			<input type="text" id="name" name="name" required>
			<div class="error-text" id="error-name"></div>
		</div>

		<div class="form-group">
			<label for="phone_number">Телефон (формат: +380661638162) *</label>
			<input type="tel" id="phone_number" name="phone_number" placeholder="+380661638162" required>
			<div class="error-text" id="error-phone_number"></div>
		</div>

		<div class="form-group">
			<label for="email">Email *</label>
			<input type="email" id="email" name="email" required>
			<div class="error-text" id="error-email"></div>
		</div>

		<div class="form-group">
			<label for="subject">Тема заявки *</label>
			<input type="text" id="subject" name="subject" required>
			<div class="error-text" id="error-subject"></div>
		</div>

		<div class="form-group">
			<label for="message">Сообщение *</label>
			<textarea id="message" name="message" required></textarea>
			<div class="error-text" id="error-message"></div>
		</div>

		<div class="form-group">
			<label>Файлы (необязательно, макс. 5 файлов по 10MB)</label>
			<div class="file-input-wrapper">
				<input type="file" id="files" name="files[]" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
				<label for="files" class="file-input-label">
					  Выберите файлы
				</label>
			</div>
			<div class="selected-files" id="selectedFiles"></div>
			<div class="error-text" id="error-files"></div>
		</div>

		<button type="submit" class="submit-btn" id="submitBtn">
			Отправить заявку
			<span class="loader" id="loader"></span>
		</button>
	</form>
</div>

<script src="{{ asset('js/widget.js') }}"></script>
</body>
</html>