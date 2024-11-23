window.addEventListener('load', () => {
    const buttonNormal = document.querySelector('.radio-normal');
    const buttonRandom = document.querySelector('.radio-random');
    const stampNormal = document.querySelector('.stamp-normal');
    const stampNormalImg = document.querySelector('.stamp-normal-img');
    const stampRandom = document.querySelector('.stamp-random');
    const stampForm = document.querySelector('.main-inner-form-stamp');
    const stampImages = [];
    const stampImages2 = [];
    const stampProbabilities = [];
    const stampProbabilities2 = [];
    const stampProbTitle = [];
    const buttonRandomAdd = document.querySelector('.stamp-random-add');
    const buttonRandomRemove = document.querySelector('.stamp-random-remove');
    const probAlert = document.querySelector('.stamp-random-alert');
    const buttonSubmit = document.querySelector('.stamp-submit-button');
    const stampImagePreview = document.querySelector('.stamp-normal-img-preview');
    const stampImagePreviews = [];
    const stampRandomCount = [];
    const stampRandomPanel = document.querySelector('.stamp-random-panel');

    const checkProb = () => {
        let probSum = 0;
        let probInfo = '';
        for (let i = 0; i < stampProbabilities.length; i += 1) {
            if (stampProbabilities2[i].value !== '' && stampProbabilities[i].style.display === 'block') {
                if (Number.isInteger(Number(stampProbabilities2[i].value)) === false) {
                    if (probInfo !== 'sign') {
                        probInfo = 'integer';
                    }
                } else if (Number(stampProbabilities2[i].value) < 0) {
                    probInfo = 'sign';
                } else {
                    probSum += Number(stampProbabilities2[i].value);
                }
            } else if (stampProbabilities[i].style.display === 'block') {
                probInfo = 'none';
                break;
            }
        }

        if (probInfo === 'integer') {
            probAlert.textContent = '確率に整数以外の数値が入力されています。';
            probAlert.style.display = 'block';
            buttonSubmit.type = 'button';
            buttonSubmit.style.backgroundColor = 'gray';
        } else if (probInfo === 'sign') {
            probAlert.textContent = '確率に負の値が入力されています。';
            probAlert.style.display = 'block';
            buttonSubmit.type = 'button';
            buttonSubmit.style.backgroundColor = 'gray';
        } else if (probInfo === 'none') {
            probAlert.textContent = '全てのスタンプに確率を設定してください。';
            probAlert.style.display = 'block';
            buttonSubmit.type = 'button';
            buttonSubmit.style.backgroundColor = 'gray';
        } else if (probSum !== 100) {
            probAlert.textContent = '確率の合計値が100になっていません。';
            probAlert.style.display = 'block';
            buttonSubmit.type = 'button';
            buttonSubmit.style.backgroundColor = 'gray';
        } else {
            probAlert.textContent = '';
            probAlert.style.display = 'none';
            buttonSubmit.type = 'submit';
            buttonSubmit.style.backgroundColor = 'lightskyblue';
        }
    }

    for (let i = 0; i < 5; i += 1) {
        stampImages.push(document.querySelector('.stamp-img-' + i.toString() + '-button'));
        stampImages2.push(document.querySelector('.stamp-img-' + i.toString()));
        stampProbabilities.push(document.querySelector('.stamp-prob-' + i.toString()));
        stampProbabilities2.push(document.querySelector('.stamp-prob-' + i.toString() + '-data'));
        stampProbTitle.push(document.querySelector('.stamp-prob-title-' + i.toString()));
        stampImages[i].style.display = 'none';
        stampImages2[i].style.display = 'none';
        stampProbabilities[i].style.display = 'none';
        stampProbTitle[i].style.display = 'none';
        stampImagePreviews.push(document.querySelector('.stamp-normal-img-preview-' + i.toString()));
        stampRandomCount.push(document.querySelector('.stamp-random-count' + i.toString()));
    }

    buttonNormal.addEventListener('input', () => {
        stampNormal.style.display = 'flex';
        stampNormalImg.style.display = 'block';
        stampNormalImg.setAttribute('required', '');
        stampRandom.style.display = 'none';
        stampForm.action = 'make_stamp.php';
        buttonSubmit.type = 'submit';
        buttonSubmit.style.backgroundColor = 'lightskyblue';
        probAlert.textContent = '';
        probAlert.style.display = 'none';
        stampImagePreview.src = './images/preview-back.png';
        stampRandomPanel.scrollBy(-1500, 0);

        for (let i = 0; i < 5; i += 1) {
            stampImages[i].style.display = 'none';
            stampProbabilities[i].style.display = 'none';
            stampProbTitle[i].style.display = 'none';
            stampImages2[i].style.display = 'none';
            stampImages2[i].removeAttribute('required');
            stampImages2[i].value = '';
            stampProbabilities2[i].value = '';
            stampProbabilities2[i].removeAttribute('required');
            stampImagePreviews[i].src = './images/preview-back.png';
            if (i < 2) {
                stampRandomCount[i].style.display = 'block';
            } else {
                stampRandomCount[i].style.display = 'none';
            }
            if (i === 0) {
                stampRandomCount[i].style.backgroundColor = 'lightskyblue';
            } else {
                stampRandomCount[i].style.backgroundColor = 'lightgray';
            }
        }
    });

    buttonRandom.addEventListener('input', () => {
        stampNormal.style.display = 'none';
        stampNormalImg.style.display = 'none';
        stampNormalImg.removeAttribute('required');
        stampRandom.style.display = 'flex';
        stampForm.action = 'make_stamp2.php';
        stampImagePreview.src = './images/preview-back.png';
        stampRandomPanel.scrollBy(-1500, 0);

        for (let i = 0; i < 5; i += 1) {
            if (i < 2) {
                stampImages[i].style.display = 'block';
                stampProbabilities[i].style.display = 'block';
                stampProbTitle[i].style.display = 'flex';
                stampImages2[i].style.display = 'block';
                stampImages2[i].setAttribute('required', '');
                stampImages2[i].value = '';
                stampProbabilities2[i].value = '';
                stampProbabilities2[i].setAttribute('required', '');
                stampImagePreviews[i].src = './images/preview-back.png';
                stampRandomCount[i].style.display = 'block';
            } else {
                stampImages[i].style.display = 'none';
                stampProbabilities[i].style.display = 'none';
                stampProbTitle[i].style.display = 'none';
                stampImages2[i].style.display = 'none';
                stampImages2[i].removeAttribute('required');
                stampImages2[i].value = '';
                stampProbabilities2[i].value = '';
                stampProbabilities2[i].removeAttribute('required');
                stampImagePreviews[i].src = './images/preview-back.png';
                stampRandomCount[i].style.display = 'none';
            }
            if (i === 0) {
                stampRandomCount[i].style.backgroundColor = 'lightskyblue';
            } else {
                stampRandomCount[i].style.backgroundColor = 'lightgray';
            }
        }
        checkProb();
    });

    buttonRandomAdd.addEventListener('click', () => {
        for (let i = 2; i < 5; i += 1) {
            if (stampImages[i].style.display === 'none') {
                stampImages[i].style.display = 'block';
                stampProbabilities[i].style.display = 'block';
                stampProbTitle[i].style.display = 'flex';
                stampImages2[i].style.display = 'block';
                stampImages2[i].setAttribute('required', '');
                stampImages2[i].value = '';
                stampProbabilities2[i].value = '';
                stampProbabilities2[i].setAttribute('required', '');
                stampImagePreviews[i].src = './images/preview-back.png';
                stampRandomCount[i].style.display = 'block';
                break;
            }
        }
        checkProb();
    });

    buttonRandomRemove.addEventListener('click', () => {
        for (let i = 4; i > 1; i -= 1) {
            if (stampImages[i].style.display === 'block') {
                stampImages[i].style.display = 'none';
                stampProbabilities[i].style.display = 'none';
                stampProbTitle[i].style.display = 'none';
                stampImages2[i].style.display = 'none';
                stampImages2[i].removeAttribute('required');
                stampImages2[i].value = '';
                stampProbabilities2[i].value = '';
                stampProbabilities2[i].removeAttribute('required');
                stampImagePreviews[i].src = './images/preview-back.png';
                stampRandomCount[i].style.display = 'none';
                if (stampRandomCount[i].style.backgroundColor === 'lightskyblue') {
                    stampRandomCount[i].style.backgroundColor = 'lightgray';
                    stampRandomCount[i - 1].style.backgroundColor = 'lightskyblue';
                }
                break;
            }
        }
        checkProb();
    });

    stampProbabilities2[0].addEventListener('input', () => {
        checkProb();
    });

    stampProbabilities2[1].addEventListener('input', () => {
        checkProb();
    });

    stampProbabilities2[2].addEventListener('input', () => {
        checkProb();
    });

    stampProbabilities2[3].addEventListener('input', () => {
        checkProb();
    });

    stampProbabilities2[4].addEventListener('input', () => {
        checkProb();
    });
});