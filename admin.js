document.getElementById('appointmentForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('book_appointment.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        
        window.location.href = 'admin.html';
    })
    .catch(error => console.error('Error:', error));