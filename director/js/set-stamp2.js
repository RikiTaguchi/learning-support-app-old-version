window.addEventListener('load', () => {
    if (document.querySelector('.stamp-count-data').textContent !== '1') {
        const stampNumber = Number(document.querySelector('.stamp-count-data').textContent);

        const stampImages2 = [];
        const stampProbabilities2 = [];
        const probAlert = document.querySelector('.stamp-random-alert');
        const buttonSubmit = document.querySelector('.stamp-submit-button');
        const stampRandomCount = [];

        const checkProb = () => {
            let probSum = 0;
            let probInfo = '';
            for (let i = 0; i < stampNumber; i += 1) {
                if (stampProbabilities2[i].value !== '') {
                    if (Number.isInteger(Number(stampProbabilities2[i].value)) === false) {
                        if (probInfo !== 'sign') {
                            probInfo = 'integer';
                        }
                    } else if (Number(stampProbabilities2[i].value) < 0) {
                        probInfo = 'sign';
                    } else {
                        probSum += Number(stampProbabilities2[i].value);
                    }
                } else {
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

        for (let i = 0; i < stampNumber; i += 1) {
            stampImages2.push(document.querySelector('.stamp-img-' + i.toString()));
            stampProbabilities2.push(document.querySelector('.stamp-prob-' + i.toString() + '-data'));
            stampRandomCount.push(document.querySelector('.stamp-random-count' + i.toString()));
            stampImages2[i].style.display = 'block';
            stampRandomCount[i].style.display = 'block';
            stampProbabilities2[i].addEventListener('input', () => {
                checkProb();
            });
        }
    } else {
        const stampImage = document.querySelector('.stamp-normal-img');
        stampImage.style.display = 'block';
    }
});