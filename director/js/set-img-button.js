window.addEventListener('load', () => {
    const fileButton = document.querySelector('.stamp-normal-img-button');
    const fileInput = document.querySelector('.stamp-normal-img');
    const filePreview = document.querySelector('.stamp-normal-img-preview');
    fileButton.addEventListener('click', () => {
        if (fileInput) {
            fileInput.click();
        }
    });
    fileInput.addEventListener('change', (event) => {
        let [imageUrl] = event.target.files;
        if (imageUrl) {
            filePreview.setAttribute('src', URL.createObjectURL(imageUrl));
        } else {
            filePreview.setAttribute('src', './images/preview-back.png');
        }
    });

    const fileButton0 = document.querySelector('.stamp-img-0-button');
    const fileInput0 = document.querySelector('.stamp-img-0');
    const filePreview0 = document.querySelector('.stamp-normal-img-preview-0');
    fileButton0.addEventListener('click', () => {
        if (fileInput0) {
            fileInput0.click();
        }
    });
    fileInput0.addEventListener('change', (event) => {
        let [imageUrl] = event.target.files;
        if (imageUrl) {
            filePreview0.setAttribute('src', URL.createObjectURL(imageUrl));
        } else {
            filePreview0.setAttribute('src', './images/preview-back.png');
        }
    });

    const fileButton1 = document.querySelector('.stamp-img-1-button');
    const fileInput1 = document.querySelector('.stamp-img-1');
    const filePreview1 = document.querySelector('.stamp-normal-img-preview-1');
    fileButton1.addEventListener('click', () => {
        if (fileInput1) {
            fileInput1.click();
        }
    });
    fileInput1.addEventListener('change', (event) => {
        let [imageUrl] = event.target.files;
        if (imageUrl) {
            filePreview1.setAttribute('src', URL.createObjectURL(imageUrl));
        } else {
            filePreview1.setAttribute('src', './images/preview-back.png');
        }
    });

    const fileButton2 = document.querySelector('.stamp-img-2-button');
    const fileInput2 = document.querySelector('.stamp-img-2');
    const filePreview2 = document.querySelector('.stamp-normal-img-preview-2');
    fileButton2.addEventListener('click', () => {
        if (fileInput2) {
            fileInput2.click();
        }
    });
    fileInput2.addEventListener('change', (event) => {
        let [imageUrl] = event.target.files;
        if (imageUrl) {
            filePreview2.setAttribute('src', URL.createObjectURL(imageUrl));
        } else {
            filePreview2.setAttribute('src', './images/preview-back.png');
        }
    });

    const fileButton3 = document.querySelector('.stamp-img-3-button');
    const fileInput3 = document.querySelector('.stamp-img-3');
    const filePreview3 = document.querySelector('.stamp-normal-img-preview-3');
    fileButton3.addEventListener('click', () => {
        if (fileInput3) {
            fileInput3.click();
        }
    });
    fileInput3.addEventListener('change', (event) => {
        let [imageUrl] = event.target.files;
        if (imageUrl) {
            filePreview3.setAttribute('src', URL.createObjectURL(imageUrl));
        } else {
            filePreview3.setAttribute('src', './images/preview-back.png');
        }
    });

    const fileButton4 = document.querySelector('.stamp-img-4-button');
    const fileInput4 = document.querySelector('.stamp-img-4');
    const filePreview4 = document.querySelector('.stamp-normal-img-preview-4');
    fileButton4.addEventListener('click', () => {
        if (fileInput4) {
            fileInput4.click();
        }
    });
    fileInput4.addEventListener('change', (event) => {
        let [imageUrl] = event.target.files;
        if (imageUrl) {
            filePreview4.setAttribute('src', URL.createObjectURL(imageUrl));
        } else {
            filePreview4.setAttribute('src', './images/preview-back.png');
        }
    });
});