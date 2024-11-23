window.addEventListener('load', () => {
    const btn = document.querySelector('.btn-feedback');
    if (btn.textContent === '復習リストに追加') {
        btn.style.backgroundColor = 'lightskyblue';
    } else {
        btn.style.backgroundColor = '#ff69b4';
    }
});