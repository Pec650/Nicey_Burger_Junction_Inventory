let show = false;

const showPassword = document.getElementById('show-password');
showPassword.addEventListener('click', () => {
    const passwordInput = document.getElementById('password-input');
    const hidePassword = document.getElementById('hide-password');
    show = !show;
    if (show) {
        passwordInput.type = 'text';
        hidePassword.style.height = '0px';
    } else {
        passwordInput.type = 'password';
        hidePassword.style.height = '55px';
    }
});