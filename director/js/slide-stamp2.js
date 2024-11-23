window.addEventListener('load', () => {
    if (document.querySelector('.stamp-count-data').textContent !== '1') {
        const stampNumber = Number(document.querySelector('.stamp-count-data').textContent);

        const stampPanel = document.querySelector('.stamp-random-panel');
        const buttonLeft = document.querySelector('.stamp-random-left');
        const buttonRight = document.querySelector('.stamp-random-right');
        const stampRandomCount = []

        for (let i = 0; i < stampNumber; i += 1) {
            stampRandomCount.push(document.querySelector('.stamp-random-count' + i.toString()));
        }

        let panelWidth = 0;
        if (window.matchMedia('(max-width: 767px)').matches) {
            panelWidth = 220;
        } else {
            panelWidth = 300;
        }

        buttonLeft.addEventListener('click', () => {
            for (let t = 0; t < panelWidth; t += 1) {
                setTimeout(() => { stampPanel.scrollBy(-1, 0); }, t);
            }

            for (let i = 1; i < stampNumber; i += 1) {
                if (stampRandomCount[i].style.backgroundColor === 'lightskyblue') {
                    stampRandomCount[i].style.backgroundColor = 'lightgray';
                    stampRandomCount[i - 1].style.backgroundColor = 'lightskyblue';
                    break;
                }
            }
        });

        buttonRight.addEventListener('click', () => {
            for (let t = 0; t < panelWidth; t += 1) {
                setTimeout(() => { stampPanel.scrollBy(1, 0); }, t);
            }

            for (let i = 0; i < (stampNumber - 1); i += 1) {
                if (stampRandomCount[i].style.backgroundColor === 'lightskyblue') {
                    stampRandomCount[i].style.backgroundColor = 'lightgray';
                    stampRandomCount[i + 1].style.backgroundColor = 'lightskyblue';
                    break;
                }
            }
        });
    }
});