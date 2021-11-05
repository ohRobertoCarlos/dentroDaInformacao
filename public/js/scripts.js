
//Lógica da paginação de noticias na seção de todas notícias
if(document.title == 'Todas notícias'){
    let containerPagination = document.getElementById('pagination');
    let pageAtual = containerPagination.getAttribute('pageatual');
    let linkPageAtual = document.getElementById('page_'+pageAtual);
    linkPageAtual.setAttribute('style', 'background-color: blue');
}

//Menu responsivo
var menu = document.querySelector('nav');

if(window.innerWidth <= 780){
    menu.style.display = 'none';
}
window.addEventListener('resize', function(){
    if(this.innerWidth <= 780){
        menu.style.display = 'none';
    }else{
        menu.style.display = 'flex';
    }
});




