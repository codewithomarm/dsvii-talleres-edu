document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="registro.php"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            let valid = true;

            if (form.nombre_completo.value.trim() === '') valid = false;

            const email = form.correo.value.trim();
            if (!/^\S+@\S+\.\S+$/.test(email)) valid = false;

            if (form.usuario.value.trim() === '') valid = false;

            if (form.password.value.length < 6) valid = false;

            if (!/^\d{2}$/.test(form.id1.value) || !/^\d{5}$/.test(form.id2.value) || !/^\d{5}$/.test(form.id3.value)) valid = false;

            if (!valid) {
                alert('Por favor, complete correctamente todos los campos.');
                e.preventDefault();
            }
        });
    }
});
