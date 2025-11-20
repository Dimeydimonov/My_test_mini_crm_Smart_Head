
document.getElementById('files').addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    const fileList = document.getElementById('selectedFiles');

    if (files.length > 0) {
        fileList.textContent = `Выбрано файлов: ${files.length} - ${files.map(f => f.name).join(', ')}`;
    } else {
        fileList.textContent = '';
    }
});


document.getElementById('ticketForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    document.querySelectorAll('.error-text').forEach(el => el.textContent = '');
    const messageEl = document.getElementById('message');
    messageEl.style.display = 'none';

    const submitBtn = document.getElementById('submitBtn');
    const loader = document.getElementById('loader');
    submitBtn.disabled = true;
    loader.style.display = 'inline-block';

    const formData = new FormData(this);

    try {
        const response = await fetch('/api/tickets', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await response.json();

        if (response.ok) {
            messageEl.className = 'message success';
            messageEl.textContent =  data.message;
            messageEl.style.display = 'block';
            this.reset();
            document.getElementById('selectedFiles').textContent = '';
        } else if (response.status === 422) {
            Object.keys(data.errors).forEach(field => {
                const errorElement = document.getElementById(`error-${field}`);
                if (errorElement) errorElement.textContent = data.errors[field][0];
            });
            messageEl.className = 'message error';
            messageEl.textContent = 'Пожалуйста, исправьте ошибки в форме';
            messageEl.style.display = 'block';
        } else if (response.status === 429) {
            messageEl.className = 'message error';
            messageEl.textContent = data.message;
            messageEl.style.display = 'block';
        } else {
            messageEl.className = 'message error';
            messageEl.textContent = 'Произошла ошибка при отправке';
            messageEl.style.display = 'block';
        }
    } catch (error) {
        messageEl.className = 'message error';
        messageEl.textContent = 'Ошибка соединения с сервером';
        messageEl.style.display = 'block';
        console.error('Error:', error);
    } finally {
        submitBtn.disabled = false;
        loader.style.display = 'none';
    }
});
