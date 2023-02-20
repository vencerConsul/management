require('./bootstrap');


if(document.querySelector('.alert')){
    setTimeout(() => {
        document.querySelector('.alert').style.display = 'none';
    }, 10000);
}

