window.addEventListener('load', () => {
    const loginId = document.querySelector('.main-form-info-login');
    const userPass = document.querySelector('.main-form-info-pass');

    const cookies = document.cookie.split(';');

    for (let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i].split('=');
        if (cookie[0] === 'director_id' || cookie[0] === ' director_id') {
            loginId.value = cookie[1];
        } else if (cookie[0] === ' director_pass' || cookie[0] === 'director_pass') {
            userPass.value = cookie[1];
        }
    }
});