window.addEventListener('load', () => {
    const loginId = document.querySelector('.info-login-type').textContent;
    const panel = document.querySelector('.main-inner-toggle-button');
    const slideType = document.querySelector('.info-submit');

    const options = {
        duration: 500,
        easing: 'ease',
        fill: 'forwards',
    };

    const options2 = {
        duration: 3000,
        easing: 'ease',
        fill: 'forwards',
    };

    const slideNext = {
        transform: ['rotate3d(1, 0, 0, 180deg)', 'rotate3d(1, 0, 0, 0deg)'],
    };

    const slideBack = {
        transform: ['rotate3d(1, 0, 0, -180deg)', 'rotate3d(1, 0, 0, 0deg)'],
    };

    const slideStart = {
        transform: ['rotate3d(1, 0, 0, 180deg)', 'rotate3d(1, 0, 0, 0deg)'],
    };

    const displayNotice = {
        translate: ['0 -100%', '0 20%', '0 20%', '0 20%', '0 20%', '0 20%', '0 -100%'],
        opacity: [0, 1, 1, 1, 1, 1, 0],
    };

    panel.style.display = 'block';

    if (loginId === '000000') {
        if (slideType.textContent === 'Next') {
            panel.style.display = 'block';
            panel.animate(slideNext, options);
        } else if (slideType.textContent === 'Back') {
            panel.style.display = 'block';
            panel.animate(slideBack, options);
        } else {
            panel.style.display = 'block';
            panel.animate(slideStart, options);
        }
    } else {
        const infoFeedback = document.querySelector('.info-feedback-text').textContent;

        if (infoFeedback !== 'feedback') {
            if (slideType.textContent === 'Next') {
                panel.style.display = 'block';
                panel.animate(slideNext, options);
            } else if (slideType.textContent === 'Back') {
                panel.style.display = 'block';
                panel.animate(slideBack, options);
            } else {
                panel.style.display = 'block';
                panel.animate(slideStart, options);
            }
        } else {
            const buttonFeedback = document.querySelector('.btn-feedback').textContent;
            const noticeMessage = document.querySelector('.main-notice-feedback');
            const noticeMessageText = document.querySelector('.main-notice-feedback-text');

            if (buttonFeedback === '復習リストに追加') {
                noticeMessageText.textContent = '復習リストから削除しました。';
                noticeMessage.animate(displayNotice, options2);
            } else if (buttonFeedback === '復習リストから削除') {
                noticeMessageText.textContent = '復習リストに追加しました。';
                noticeMessage.animate(displayNotice, options2);
            } else if (buttonFeedback === '復習リストから削除済') {
                noticeMessageText.textContent = '復習リストから削除しました。';
                noticeMessage.animate(displayNotice, options2);
            }
        }
    }
})