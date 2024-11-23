window.addEventListener('load', () => {
    if (document.querySelector('.stamp-count-data').textContent === '1') {
        const fileButton = document.querySelector('.stamp-normal-img-button');
        const fileInput = document.querySelector('.stamp-normal-img');
        const filePreview = document.querySelector('.stamp-normal-img-preview');
        const infoInput = document.querySelector('.stamp-info-input');
        fileButton.addEventListener('click', () => {
            if (fileInput) {
                fileInput.click();
            }
        });
        fileInput.addEventListener('change', (event) => {
            let [imageUrl] = event.target.files;
            if (imageUrl) {
                filePreview.setAttribute('src', URL.createObjectURL(imageUrl));
                infoInput.setAttribute('value', 'set');
            } else {
                filePreview.setAttribute('src', './images/preview-back.png');
                infoInput.setAttribute('value', 'none');
            }
        });
    } else {
        const stampNumber = Number(document.querySelector('.stamp-count-data').textContent);
        const fileButtons = [];
        const fileInputs = [];
        const filePreviews = [];
        const infoInputs = [];

        for (let i = 0; i < stampNumber; i += 1) {
            fileButtons.push(document.querySelector('.stamp-img-' + i.toString() + '-button'));
            fileInputs.push(document.querySelector('.stamp-img-' + i.toString()));
            filePreviews.push(document.querySelector('.stamp-normal-img-preview-' + i.toString()));
            infoInputs.push(document.querySelector('.stamp-info-input-' + i.toString()));

            fileButtons[i].addEventListener('click', () => {
                if (fileInputs[i]) {
                    fileInputs[i].click();
                }
            });

            fileInputs[i].addEventListener('change', (event) => {
                let [imageUrl] = event.target.files;
                if (imageUrl) {
                    filePreviews[i].setAttribute('src', URL.createObjectURL(imageUrl));
                    infoInputs[i].setAttribute('value', 'set');
                } else {
                    filePreviews[i].setAttribute('src', './images/preview-back.png');
                    infoInputs[i].setAttribute('value', 'none');
                }
            });
        }
    }
});