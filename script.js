document.getElementById('rsvpForm').addEventListener('submit', function(event) {
    event.preventDefault();     
    const form = event.target;
    const formData = new FormData(form);
    const messageElement = document.getElementById('rsvpMessage');
    messageElement.style.display = 'none'; 
    fetch('handle_rsvp.php', { 
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        messageElement.textContent = data.message;
        if (data.status === 'success') {
            messageElement.style.backgroundColor = 'lightgreen';
            form.reset(); 
        } else {
            messageElement.style.backgroundColor = 'lightcoral';
        }
        messageElement.style.display = 'block';
    })
    .catch(error => {
        messageElement.textContent = 'An unexpected error occurred during submission.';
        messageElement.style.backgroundColor = 'yellow';
        messageElement.style.display = 'block';
        console.error('Error:', error);
    });
});