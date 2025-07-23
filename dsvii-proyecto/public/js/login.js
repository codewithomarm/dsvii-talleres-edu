document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');

    if (!form) return;

    form.addEventListener('submit', (e) => {
        const username = form.username ? form.username.value.trim() : '';
        const email = form.email ? form.email.value.trim() : '';
        const password = form.password.value.trim();

        // Validar usuario o correo (depende de lo que uses)
        if (username !== undefined && username === '') {
            alert('Por favor, ingrese su nombre de usuario.');
            e.preventDefault();
            return;
        }

        if (email !== undefined && email === '') {
            alert('Por favor, ingrese su correo electrónico.');
            e.preventDefault();
            return;
        }

        if (password === '') {
            alert('Por favor, ingrese su contraseña.');
            e.preventDefault();
            return;
        }
    });
});
