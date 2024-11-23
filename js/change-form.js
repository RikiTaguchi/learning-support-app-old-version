window.addEventListener('load', () => {
    const urlString = window.location.href;
    const url = new URL(urlString);
    const errorType = url.searchParams.get('banner');
    const tableId = url.searchParams.get('table_id');
    const imgId = url.searchParams.get('img_id');
    const imgExtention = url.searchParams.get('img_extention');
    const imgExtention0 = url.searchParams.get('img_extention_0');
    const formArea = document.querySelector('.main-login-form-area');

    let infoParam;
    if (imgExtention !== null) {
        infoParam = '?table_id=' + tableId + '&img_id=' + imgId + '&img_extention=' + imgExtention;
    } else {
        infoParam = '?table_id=' + tableId + '&img_id=' + imgId + '&img_extention_0=' + imgExtention0;
    }
    
    if (errorType === '41') {
        formArea.action = 'get_stamp_check.php' + infoParam;
    }
});