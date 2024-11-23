window.addEventListener('load', () => {
    const btn = document.querySelector('.btn-feedback');
    if (btn.style.pointerEvents !== 'none') {
        btn.style.backgroundColor = 'lightskyblue';
    } else {
        btn.style.backgroundColor = 'gray';
    }
});