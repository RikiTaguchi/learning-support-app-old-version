function checkSubmit() {
    if (confirm('本当に削除しますか？')) {
        return true;
    } else {
        return false;
    }
}

function checkSubmit2() {
    if (confirm('管理者アカウントを削除すると、これまでに作成したスタンプ、ユーザーが取得したスタンプの情報は保持されますが、変更が不可能になります。本当に削除しますか？')) {
        return true;
    } else {
        return false;
    }
}

function checkSubmit3() {
    if (confirm('本当にこのスタンプを削除しますか？')) {
        return true;
    } else {
        return false;
    }
}

function checkSubmit4() {
    const stampNumber = Number(document.querySelector('.stamp-count-data').textContent);
    const previewUrl = 'https://wordsystemforstudents.com/director/images/preview-back.png';
    const bannerArea = document.querySelector('.main-banner');
    const bannerMessage = document.querySelector('.main-banner-text');
    const options = {
        duration: 3000,
        easing: 'ease',
        fill: 'forwards',
    };
    const displayBanner = {
        translate: ['0 -100%', '0 20%', '0 20%', '0 20%', '0 20%', '0 20%', '0 -100%'],
        opacity: [0, 1, 1, 1, 1, 1, 0],
    };

    if (stampNumber === 1) {
        if (document.querySelector('.stamp-normal-img-preview').src !== previewUrl) {
            return true;
        } else {
            bannerMessage.textContent = 'スタンプ画像を登録してください。';
            bannerArea.animate(displayBanner, options);
            return false;
        }
    } else {
        let checkStamp = true;
        for (let i = 0; i < stampNumber; i += 1) {
            if (document.querySelector('.stamp-normal-img-preview-' + i.toString()).src === previewUrl) {
                checkStamp = false;
                break;
            } else if (i === (stampNumber - 1)) {
                checkStamp = true;
            }
        }
        if (checkStamp === true) {
            return true;
        } else {
            bannerMessage.textContent = '全てのスタンプ画像を登録してください。';
            bannerArea.animate(displayBanner, options);
            return false;
        }
    }
}

function checkSubmit5() {
    if (confirm('本当に削除しますか？削除後も、ユーザーが既に取得しているこのスタンプの情報はサーバーに保管されます。')) {
        return true;
    } else {
        return false;
    }
}