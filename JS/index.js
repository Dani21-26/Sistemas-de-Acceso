document.getElementById('loginBtn').
    addEventListener('click', function () {
        document.getElementById('loginModal').
            classList.remove('hidden');
    });
document.getElementById('closeBtn').
    addEventListener('click', function () {
        document.getElementById('loginModal').
            classList.add('hidden');
    });
document.getElementById('togglePassword').
    addEventListener('click', function (event) {
        event.preventDefault();
        let passwordInput =
            document.getElementById('password');
        let eyeIcon =
            document.getElementById('eyeIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });
    document.getElementById('loginSubmit').addEventListener('click', function (event) {
        event.preventDefault();
        let username = document.getElementById('username').value;
        let password = document.getElementById('password').value;
        document.getElementById('usernameError').innerText = '';
        document.getElementById('passwordError').innerText = '';
        document.getElementById('forgotPasswordError').innerText = '';
    
        // Validación de los datos del formulario
        if (username.trim() === '' || password.trim() === '') {
            // Mostrar mensajes de error según corresponda
            if (username.trim() === '') {
                document.getElementById('usernameError').innerText = 'El nombre de usuario no puede estar vacío';
            }
            if (password.trim() === '') {
                document.getElementById('passwordError').innerText = 'La contraseña no puede estar vacía';
            }
            return;
        }
    // Enviar los datos del formulario al servidor
    fetch('login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirigir al usuario a la nueva vista
            window.location.href = './pages/panel.php'; 
        } else {
            // Mostrar mensaje de error
            document.getElementById('passwordError').innerText = data.message;
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
});
    
    
document.getElementById('forgotPasswordLink').
    addEventListener('click', function () {
        document.getElementById('forgotPasswordModal').
            classList.remove('hidden');
    });
document.getElementById('closeForgotPasswordBtn').
    addEventListener('click', function () {
        document.getElementById('forgotPasswordModal').
            classList.add('hidden');
    });
document.getElementById('forgotPasswordSubmit').
    addEventListener('click', function (event) {
        event.preventDefault();
        let email = document.getElementById('email').value;
        document.getElementById('emailError').innerText = '';
        if (email.trim() === '' || !isValidEmail(email)) {
            document.getElementById('emailError').
                innerText = 'Por favor, introduce una dirección de correo electrónico válida';
            return;
        }
        alert('Reset Link Sent Successfully!');
        document.getElementById('forgotPasswordModal').
            classList.add('hidden');
    });
function isValidEmail(email) {
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}