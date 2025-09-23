document.addEventListener("DOMContentLoaded", function () {

    // ===== Delete Confirmation =====
    const deleteButtons = document.querySelectorAll('a.btn-danger');
    deleteButtons.forEach(function(btn) {
        btn.addEventListener('click', function(e){
            if(!confirm("Are you sure you want to delete this record?")){
                e.preventDefault();
            }
        });
    });

    // ===== JWT Token Setup for AJAX (if needed) =====
    // Uncomment & replace 'your-jwt-token' with dynamic token from session/localStorage
    /*
    const token = localStorage.getItem('jwt_token'); // or fetch from hidden input
    if(token){
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e){
                e.preventDefault();
                const formData = new FormData(form);
                fetch(form.action, {
                    method: form.method,
                    headers: {
                        'Authorization': 'Bearer ' + token
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success){
                        window.location.reload();
                    } else {
                        alert(data.message || 'Error occurred');
                    }
                })
                .catch(err => console.error(err));
            });
        });
    }
    */

    // ===== Appointment Date/Time Validation =====
    const appointmentForm = document.querySelector('form');
    if(appointmentForm && appointmentForm.querySelector('[name="start_datetime"]')){
        appointmentForm.addEventListener('submit', function(e){
            const start = new Date(appointmentForm.querySelector('[name="start_datetime"]').value);
            const end = new Date(appointmentForm.querySelector('[name="end_datetime"]').value);
            if(start >= end){
                alert('End datetime must be after start datetime.');
                e.preventDefault();
            }
        });
    }

});
