window.addEventListener ('load', () => {
    const panel = document.querySelector('.main-inner-toggle-button');
    const question = document.querySelector('.main-inner-word');
    const answer = document.querySelector('.main-inner-answer');

    const options = {
        duration: 500,
        easing: 'ease',
        fill: 'forwards',
    };

    const rotate = {
        transform: ['rotate3d(0, 1, 0, 180deg)', 'rotate3d(0, 1, 0, 0deg)'],
    };

    panel.addEventListener ('click', () => {
        if (question.style.display === 'block') {
            question.style.display = 'none';
            answer.style.display = 'block';
            answer.animate(rotate, options);
            panel.animate(rotate, options);
        } else {
            question.style.display = 'block';
            answer.style.display = 'none';
            question.animate(rotate, options);
            panel.animate(rotate, options);
        }
    });
});