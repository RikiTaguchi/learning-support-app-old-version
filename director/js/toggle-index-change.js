window.onload = () => { 
    const select = document.querySelector('select.main-form-book');
    const list = document.querySelector('ul.main-inner-list-book');
    const listItems = list.children;
    
    const toggle = (value, items) => {
        for (let item of items) {
            item.style.display = 'none';
            let data = item.querySelector('p.book-id').textContent;
            
            if (value !== '' && value === data) {
                item.style.display = 'block';
            }
        }
    };

    select.addEventListener('change', ()=>{
        toggle(event.target.value, listItems);
    }, false);
};