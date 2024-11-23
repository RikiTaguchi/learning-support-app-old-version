window.addEventListener('load', () => {
    const button1 = document.querySelector('.main-inner-button1-index');
    const button2 = document.querySelector('.main-inner-button2-index');
    const index = document.querySelector('.main-inner-list-index');

    button1.style.display = 'block';
    button2.style.display = 'none';
    index.style.display = 'none';

    const options = {
        duration: 500,
        easing: 'ease',
        fill: 'forwards',
    };

    const openIndex = {
        opacity: [0, 1],
        height: ['0%', '100%'],
    };

    button1.addEventListener('click', () => {
        button1.style.display = 'none';
        button2.style.display = 'block';
        index.style.display = 'block';
        index.animate(openIndex, options);
    });

    button2.addEventListener('click', () => {
        button1.style.display = 'block';
        button2.style.display = 'none';
        index.style.display = 'none';
    });
});
