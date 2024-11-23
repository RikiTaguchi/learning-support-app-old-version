window.addEventListener('load', () => {
    const loginId = document.querySelector('.info-login-type').textContent;
    const bookName = document.querySelector('.info-bookname').textContent;
    const mainInnerContent = document.querySelector('.main-inner-contents');

    if (loginId === '000000') {
        if (bookName === 'Vintage') {
            mainInnerContent.style.paddingBottom = '50px';
        }
    }
});