function preencheCampos()
{
    for (i=0; i<formulario.elements.length; i++) {  
        var fieldValue = formulario.elements[i].value;  
        if(fieldValue == '' || (formulario.elements[i].type=='radio' && formulario.elements[i].checked==false)) {   
            formulario.elements[i].value=formulario.elements[i].name;
            //alert();
            if(formulario.elements[i].type=='radio')
                formulario.elements[i].checked = true;

        }  
    }
}


//valida o CPF digitado
function validarCPF(cpf){

           var  cpf = $(objcpf).attr('value');

         

            // if (cpf.Equals("   ,   ,   -"))
            if (cpf == "")
                return true;

            var  multiplicador1 = new Array (10, 9, 8, 7, 6, 5, 4, 3, 2 );

            var multiplicador2 = new Array( 11, 10, 9, 8, 7, 6, 5, 4, 3, 2 );

            var tempCpf;

            var digito;

            var soma;

            var resto;

            //cpf = cpf.Trim();

            for(i=0;i<cpf.length;i++)
            {
                cpf = cpf.replace(".", "");
                cpf = cpf.replace("-", "");
            }

          
           
                   
            if (cpf.length != 11)
            {
                alert('CPF Invalido!');
                $(Objcpf).attr('value',"");
                $(Objcpf).focus();
                return false;
            }


            if (cpf == ("00000000000") || cpf == ("11111111111") || cpf == ("22222222222") || cpf == ("33333333333") || cpf == ("44444444444") || cpf == ("55555555555") || cpf == ("66666666666") || cpf == ("77777777777") || cpf == ("88888888888") || cpf == ("99999999999"))
              {
                  alert('CPF Invalido!');
                  $(Objcpf).attr('value',"");
                  $(Objcpf).focus();
                  return false;
              
                }



            tempCpf = cpf.substring(0, 9);

            soma = 0;



            for (i = 0; i < 9; i++)

                soma += parseInt(tempCpf.charAt(i).toString()) * multiplicador1[i];

            resto = soma % 11;

            if (resto < 2)

                resto = 0;

            else

                resto = 11 - resto;

            digito = resto.toString();

            tempCpf = tempCpf + digito;

            soma = 0;

            for (i = 0; i < 10; i++)

                soma += parseInt(tempCpf.charAt(i).toString()) * multiplicador2[i];

            resto = soma % 11;

            if (resto < 2)

                resto = 0;

            else

                resto = 11 - resto;

            digito = digito + resto.toString();



             //String.lastIndexOf(searchValue, fromIndex)

            if(cpf.substr(9,2) != digito)
            {
                                    alert('CPF Invalido!');
                                    $(Objcpf).attr('value',"");
                                    $(Objcpf).focus();
                                    return false;

            }

            return true;

        }

//valida o CNPJ digitado
function validarCNPJ(cnpj){
    
        var valida = new Array(6,5,4,3,2,9,8,7,6,5,4,3,2);
        var dig1= new Number;
        var dig2= new Number;
        
        exp = /\.|\-|\//g
        cnpj = cnpj.toString().replace( exp, "" ); 
        var digito = new Number(eval(cnpj.charAt(12)+cnpj.charAt(13)));
                
        for(i = 0; i<valida.length; i++){
                dig1 += (i>0? (cnpj.charAt(i-1)*valida[i]):0);  
                dig2 += cnpj.charAt(i)*valida[i];       
        }
        dig1 = (((dig1%11)<2)? 0:(11-(dig1%11)));
        dig2 = (((dig2%11)<2)? 0:(11-(dig2%11)));
        
        if (cnpj != "")
        {
            if(((dig1*10)+dig2) != digito)
		    {
                        return false;
		    }
        }   
        return true;
}

//valida numero inteiro com mascara
function mascaraInteiro(dom){
	  dom.value=dom.value.replace(/\D/g,'');

}




function validarData(data) 
{
            
            
            exp = /\d{2}\/\d{0,2}\/\d{4}/
        if(!exp.test(data))
        {
            return false;
        }
            
            
            
	if (data == "")
        { 
           return false;
        } 

	
	
	    dia = (data.substring(0,2)); 
            mes = (data.substring(3,5)); 
            ano = (data.substring(6,10)); 

           
            // verifica o dia valido para cada mes 
            if ((dia < 01)||(dia < 01 || dia > 30) && (  mes == 4 || mes == 6 || mes == 9 || mes == 11 ) || dia > 31) { 
                return false;
            } 

            // verifica se o mes e valido 
            if (mes < 01 || mes > 12 ) { 
               return false;
            } 

            // verifica se e ano bissexto 
            if (mes == 2 && ( dia < 01 || dia > 29 || ( dia > 28 && (parseInt(ano / 4) != ano / 4)))) { 
             return false;
            } 
            
          return true;

         
} 

function validarEmail(email)
{
      var exp = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+@[a-zA-Z0-9_.-]*\.+[a-z]{2,4}$/;
     
  if ( !exp.test(email))
  {
   return false;
  }
  return true;
}
	
//Valida Senha
function validarSenha(senha)
{
   alert('fdgfdgfdgfdg');
    exp = /^.*(?=.{6,})(?=.*\d)(?=.*[a-zA-Z]).*$/

    if(alphaRegExp.test(senha))
    {
            return true;
    }
    else
    {
            return false;
    }
}
	
function FecharDivMsgOld()
{
   
}
        
        /**
         * Função javascript para ser utilizada junto a função transmissor msg da classe ZendUtils, precisa do plugin jquery
         */
function ExibirMsg(id, msg, tipo,tempo)
{

    if(tempo <= 0)
    {jQuery(id).html(jQuery(id).html()+msg).removeClass().addClass(tipo).fadeIn("fast");
    }
    else
    {
            jQuery(id).html(jQuery(id).html()+msg).removeClass().addClass(tipo).fadeIn("fast").delay(tempo).fadeOut("slow");
    }	
}

//campo só de números entrada ie ou ff para ver qual o navegador
// codgo do campo view onkeypress="return campoNumeros(event.keyCode, event.which);"
function campoNumeros(ie, ff) {
    if (ie) {
        tecla = ie;
    } else {
        tecla = ff;
    }
 
    /**
    * 13 = [ENTER]
    * 8  = [BackSpace]
    * 9  = [TAB]
    * 46 = [Delete]
    * 48 a 57 = São os números
    */
    if ((tecla >= 48 && tecla <= 57) || (tecla == 8) || (tecla == 13) || (tecla == 9) || (tecla == 46)) {
        return true;
    }
    else {
        return false;
    }
}


function extraiScript(texto)
{//para poder executar JS denro de um ajax
    //Maravilhosa função feita pelo SkyWalker.TO do imasters/forum
    //http://forum.imasters.com.br/index.php?showtopic=165277
    // inicializa o inicio ><
    var ini = 0;
    // loop enquanto achar um script
    while (ini!=-1){
        // procura uma tag de script
        ini = texto.indexOf('<script', ini);
        // se encontrar
        if (ini >=0){
            // define o inicio para depois do fechamento dessa tag
            ini = texto.indexOf('>', ini) + 1;
            // procura o final do script
            var fim = texto.indexOf('</script>', ini);
            // extrai apenas o script
            codigo = texto.substring(ini,fim);
            // executa o script
            //eval(codigo);
            /**********************
							* Alterado por Micox - micoxjcg@yahoo.com.br
							* Alterei pois com o eval não executava funções.
							***********************/
            novo = document.createElement("script")
            novo.text = codigo;
            document.body.appendChild(novo);
        }
    }
}

function carregando(CampoDiv)
{
    pathArray = window.location.pathname.split( '/' );
    host = pathArray[1];
    
    document.getElementById(CampoDiv).innerHTML='<div id="loading" class="loading"><img src="/'+host+'/public/images/ajax_carregando.gif" width="16" height="16" />&nbsp;Aguarde...</div>';
}
	
// Funcao para mostrar resultados obtidos no AJAX - nova função
	
function ajax(url,CampoDiv)
{
		
    carregando(CampoDiv);
				
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            //document.getElementById(CampoDiv).innerHTML=xmlhttp.responseText;
				
            //para executar JS dentro do ajax
            // coloca o valor no objeto requisitado
            texto=unescape(xmlhttp.responseText.replace(/\+/g," "));
            document.getElementById(CampoDiv).innerHTML=texto;
            // executa scripts
            extraiScript(texto);/**/				
        }
    }
		
    xmlhttp.open("GET",url,false);
    xmlhttp.send();
}

/***
 * Funcao genérica para verificar se a string "comparacao" existe no "texto"
 * @param comparacao String que sera comparada com o campo hidden
 * @param texto Texto que será pesquisado
 * @example if(existeNaStr('azul','O ceu eh azul, dah')){ //Do something} 
 *          //  retorna 1, pois "chave" pertence ao segundo parametro
 * @return 1 se encontrado, caso contrario 0
 */
function existeNaStr(comparacao,texto)
{
    if(texto.indexOf(comparacao)!=-1)
        return(1);

    return(0);
}

function removeNaStr(id,campo)
{
     arrayId = document.getElementById(campo).value;

     document.getElementById(campo).value = arrayId.replace(','+id+',',","); //ele iria procurar pelo id dentro de arrayId e trocar por ","
}
/**
 * Usado tb na view logado, do modulo sistema em cadastrocontroleacesso.phtml
 * é chama dentro do ajax, ex de uso: ajaxempresa.phtml
 * retira uma substring de dentro outra string
 */
function removeId(id,tabela,campo,index)
{
    temp = eval('document.forms[0].'+campo);
    
    if(temp.length)
    {
        if(!temp[index].checked)
        {   
            arrayId = document.getElementById('arrayIdTemp'+tabela).value;

            arrayId = arrayId.replace(','+id+',',","); //ele iria procurar pelo id dentro de arrayId e trocar por ","

            document.getElementById('arrayIdTemp'+tabela).value = arrayId;
        }
    }
    else
    {
        
        if(!document.getElementById(campo).checked)
        {   
            arrayId = document.getElementById('arrayIdTemp'+tabela).value;

            arrayId = arrayId.replace(','+id+',',","); //ele iria procurar pelo id dentro de arrayId e trocar por ","

            document.getElementById('arrayIdTemp'+tabela).value = arrayId;
        }
    }
}    

/***
 * Usado tb na view logado, do modulo sistema em cadastrocontroleacesso.phtml
 * é chama dentro do ajax, ex de uso: ajaxempresa.phtml
 * coloca um id dentro de uma array
 */
function setId(id,tabela)
{
        tempArrayId = document.getElementById('arrayIdTemp'+tabela).value;
        if(!existeNaStr(','+id+',',tempArrayId) && id!='')
        {
            document.getElementById('arrayIdTemp'+tabela).value += id+',';			
        }
}

/***
 * Usado tb na view logado, do modulo sistema em cadastrocontroleacesso.phtml
 * é chama dentro do ajax, ex de uso: ajaxempresa.phtml
 * Em caso em q ha paginacao, tem q remarcar os itens anteriormentes marcados
 */
function remarcaId(tabela,campo)
{
    temp = eval('document.forms[0].'+campo);

    if(temp.length)
    {
        for (i = 0; i < temp.length; i++)
        {
            tempArrayId = document.getElementById('arrayIdTemp'+tabela).value;
            if(existeNaStr(','+temp[i].value+',',tempArrayId))
            {
                temp[i].checked = true;			
            }
        }
    }
    else
    {
        tempArrayId = document.getElementById('arrayIdTemp'+tabela).value;
        if(existeNaStr(','+temp.value+',',tempArrayId))
        {
            temp.checked = true;			
        }
    }

}

// run the currently selected effect
function runEffect(tipo,tempo) {
    // get effect type from
    var selectedEffect = 'drop';

    // most effect types need no options passed by default
    var options = {};
    // some effects have required parameters
    if ( selectedEffect === "scale" ) {
        options = {percent: 100};
    } else if ( selectedEffect === "size" ) {
        options = {to: {width: 280, height: 185}};
    }

    // run the effect
    $( "#togglerMenssagem" ).show();
    $( "#effectMenssagem" ).show( selectedEffect, options, 500, fecharDivMsg(tipo,tempo) );
};

//callback function to bring a hidden box back
function fecharDivMsg(tipo,tempo) {
    
    if(tipo)
    {
        setTimeout(function() {
            $( "#effectMenssagem:visible" ).removeAttr( "style" ).fadeOut();

        }, tempo );
    
    
        setTimeout(function() {
            document.getElementById('togglerMenssagem').style.display = 'none';

        }, (tempo+500) );
    }

};

function setMsg(titulo,conteudo,tipo)
{
    if(!tipo)
        document.getElementById('effectMenssagem').style.background = '#f00'
    
    document.getElementById('tituloMsg').innerHTML   = titulo;
    document.getElementById('conteudoMsg').innerHTML = conteudo;
    
    runEffect(tipo,2000);
}

function habilitaDiv(opcao,divHidden)
{
    tamanhoDiv = document.getElementById(divHidden).clientHeight;
    document.getElementById('transparente').style.marginTop = '-'+(tamanhoDiv+121)+'px';
    document.getElementById('transparente').style.height = tamanhoDiv+'px';
    $( "#carregar" ).position({
            my: "center center",
            at: "center center",
            of: "#transparente"
            });
            
    if(opcao)
        document.getElementById('transparente').style.visibility = '';
    else
        document.getElementById('transparente').style.visibility = 'hidden';
}

function carregaGravando()
{
    
    habilitaDiv(true,'tabs');
    var frm = $('form');        
    $.ajax({
        type: frm.attr('method'),
        url: frm.attr('action'),
        data: frm.serialize(),
        async: true,
        success: function (request,data) {
            //alert('ok');
            if($.trim(request)!='')
                setMsg('ERRO','Erro ao salvar, entre em contato com a CRIWEB!<br>'+request,0);
            else
                setMsg('Show','Salvo com sucesso!',1);
            habilitaDiv(false,'tabs');
        },
        error: function (request, status, error) {
            //setMsg('ERRO','Erro ao salvar, entre em contato com a CRIWEB.!'+request.responseText,0);
            setMsg('ERRO','Erro ao salvar, entre em contato com a CRIWEB!<br>'+request,0);
            habilitaDiv(false,'tabs');
        }
    });
   

}

function showAlert(titulo,msg){
    
    var showAlert = document.createElement('div');
    showAlert.id = 'showAlert';    
    document.body.appendChild(showAlert);
    
    document.getElementById('showAlert').innerHTML = msg;
    document.getElementById('showAlert').title = titulo;
    
    $(function() {
        $( "#showAlert" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                    
                }
            }
        });
    });
    
}