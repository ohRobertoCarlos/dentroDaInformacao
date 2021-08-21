
//Lógica da paginação de noticias na seção de todas notícias
let containerPagination = document.getElementById('pagination');
let pageAtual = containerPagination.getAttribute('pageatual');
let linkPageAtual = document.getElementById('page_'+pageAtual);
linkPageAtual.setAttribute('style', 'background-color: blue');
