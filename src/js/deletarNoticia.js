$('.botao_deletar_noticia').on('click', function(e){

  // Cookie com caminho raiz da aplicação
  let path_index = getCookie('path_index');
  // pegando id da noticia
  let idNoticia = e.currentTarget.getAttribute('id_noticia');

  let div = document.createElement('div');
  $(div).addClass('modal-deletar-noticia');
  div.innerHTML = '<h2>Deseja apagar esta notícia?</h2><section><a class="btn btn-success" id="sim">Sim</a><a class="btn btn-danger" id="nao">Não</a></section>';

  let containerNoticia = document.getElementById(idNoticia);
  containerNoticia.append(div);


  $('#sim').on('click',function(e){

    //Mandando a requisição AJAX
    $.ajax({
      url: path_index + "delete?id=" + idNoticia,
      method: "GET",
      data: {},
      success: function( result ) {
       div.remove();
       setTimeout(() => {containerNoticia.remove();} ,700);
      },
      error: function(error) {
        alert('Não foi possível apagar a notícia!');
      }
    });
  });


  $('#nao').on('click',function(e){
    $('.modal-deletar-noticia').remove();
  });
  
});