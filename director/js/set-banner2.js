window.addEventListener('load', () => {
    const bannerArea = document.querySelector('.main-banner');
    const bannerMessage = document.querySelector('.main-banner-text');

    const urlString = window.location.href;
    const url = new URL(urlString);
    const errorType = url.searchParams.get('banner');
    
    if (errorType === '22') {
        bannerMessage.textContent = '未登録の管理者アカウントです。入力内容にミスがないか確認してしてください。';
    } else if (errorType === '23') {
        bannerMessage.textContent = 'パスワードが違います。入力内容にミスがないか確認してしてください。';
    } else if (errorType === '24') {
        bannerMessage.textContent = 'データベースとの接続に失敗しました。もう一度ログインしてください。';
    } else if (errorType === '26') {
        bannerMessage.textContent = 'この管理者IDはすでに使用されているため、使用できません。';
    } else if (errorType === '27') {
        bannerMessage.textContent = '登録が完了しました。';
    } else if (errorType === '28') {
        bannerMessage.textContent = 'ログアウトが完了しました。';
    } else if (errorType === '32') {
        bannerMessage.textContent = '削除が完了しました。';
    }

    const options = {
        duration: 3000,
        easing: 'ease',
        fill: 'forwards',
    };

    const displayBanner = {
        translate: ['0 -100%', '0 20%', '0 20%', '0 20%', '0 20%', '0 20%', '0 -100%'],
        opacity: [0, 1, 1, 1, 1, 1, 0],
    };

    if (bannerMessage.textContent !== '') {
        bannerArea.animate(displayBanner, options);
    }
});