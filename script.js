document.addEventListener('DOMContentLoaded', function () {
    fetch('get_mechanics.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error fetching mechanics:', data.error);
                alert('Failed to load mechanics.');
                return;
            }

            const mechanicSelect = document.getElementById('mechanic');
            data.forEach(mechanic => {
                const option = document.createElement('option');
                option.value = mechanic.id;
                option.textContent = `${mechanic.name} (Available slots: ${mechanic.available_slots})`;
                mechanicSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load mechanics.');
        });
});