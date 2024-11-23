window.addEventListener('load', () => {
    const openButton = document.querySelector('.main-inner-button-howto1');
    const closeButton = document.querySelector('.main-inner-button-howto2');
    const howtoList = document.querySelector('.main-inner-howto');
    
    openButton.style.display = 'block';
    closeButton.style.display = 'none';

    const options = {
        duration: 1000,
        easing: 'ease',
        fill: 'forwards',
    };

    const open = {
        translate: ['250% 0', '0 0'],
    };

    const close = {
        translate: ['0 0', '250% 0'],
    };

    openButton.addEventListener('click', () => {
        openButton.style.display = 'none';
        closeButton.style.display = 'block';
        howtoList.animate(open, options);
    });

    closeButton.addEventListener('click', () => {
        openButton.style.display = 'block';
        closeButton.style.display = 'none';
        howtoList.animate(close, options);
    });

});