//Pega somente o nome da baseUrl
pathArray = window.location.pathname.split( '/' );
host = pathArray[1];

//ajax
urlAjaxEmpresa = '/'+host+'/sistema/logado/ajaxempresa';
urlAjaxTime = '/'+host+'/sistema/logado/ajaxtime';
urlAjaxCAFuncionario = '/'+host+'/sistema/logado/ajaxcafuncionario';
urlAjaxFuncionario = '/'+host+'/sistema/logado/ajaxfuncionario';
urlAjaxGrupo = '/'+host+'/sistema/logado/ajaxusuariogrupo';
urlAjaxCarregaMenuTree = '/'+host+'/sistema/logado/ajaxcarregamenutree';
urlAjaxFiltroSCT = '/'+host+'/sistema/logado/ajaxfiltrosct';
urlAjaxValidaUsuario = '/'+host+'/sistema/logado/ajaxvalidausuario';
urlAjaxValidaEmpresa = '/'+host+'/sistema/logado/ajaxvalidaempresa';
urlAjaxUtilitario = '/'+host+'/sistema/logado/ajaxutilitario';
urlAjaxOferta = '/'+host+'/sistema/logado/ajaxoferta';
urlAjaxMecBusca = '/'+host+'/default/index/ajaxmecbusca';

//http://www.browser-update.org/pt/
//Browser-Update.org - Informe o seu visitante sobre atualizações do navegador
var $buoop = {vs:{i:8,f:12,o:11,s:5,n:9}} 
$buoop.ol = window.onload; 
window.onload=function(){ 
 try {if ($buoop.ol) $buoop.ol();}catch (e) {} 
 var e = document.createElement("script"); 
 e.setAttribute("type", "text/javascript"); 
 e.setAttribute("src", "http://browser-update.org/update.js"); 
 document.body.appendChild(e); 
} 

/***
 * Preenche todos os compos de um formulario
 * funcao para ajudar no teste de formulario com varios campos
 */
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

/***
 * Para poder executar JS denro de um ajax
 * @param string Texto String a ser remodelada
 */
function extraiScript(texto)
{
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
    document.getElementById(CampoDiv).innerHTML='<div id="loading" class="loading"><img src="/'+host+'/public/images/ajax_carregando.gif" width="16" height="16" />&nbsp;Aguarde...</div>';
}
	

/***
 * Executa via ajax
 * @param String Url Url da pagina (ou action)
 * @param string CampoDiv Nome da DIV que ira receber o resultado do AJAX
 */	
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
 * Usado tb na view, do controller logado do modulo sistema, cadastrocontroleacesso.phtml
 * é chamada dentro do ajax, ex de uso: ajaxempresa.phtml
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

            arrayId = arrayId.replace(','+id+',',","); //ele ira procurar pelo id dentro de arrayId e trocar por ","

            document.getElementById('arrayIdTemp'+tabela).value = arrayId;
        }
    }
    else
    {
        if(!document.getElementById(campo).checked)
        {   
            arrayId = document.getElementById('arrayIdTemp'+tabela).value;

            arrayId = arrayId.replace(','+id+',',","); //ele ira procurar pelo id dentro de arrayId e trocar por ","

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

/***
 * Função genéria para exibir uma msg com efeito de se mover da esquerda para direita
 * @param string titulo Titulo da caixa de msg
 * @param string conteudo Texto a ser colocaco dentro da caixa
 * @param boolean tipo Se é erro (caixa na cor vermelho) ou sucesso (caixa na cor branca)
 */
function setMsg(titulo,conteudo,tipo)
{
    if(!document.getElementById('togglerMenssagem'))
    {
        var togglerMenssagem = document.createElement('div');
        togglerMenssagem.id = 'togglerMenssagem';
        togglerMenssagem.className = 'togglerMenssagem';
        document.body.appendChild(togglerMenssagem);
        $('#togglerMenssagem').append('<div id="effectMenssagem" class="ui-widget-content ui-corner-all"><h3 class="ui-widget-header ui-corner-all"><p id="tituloMsg"></p><a id="btnfechardiv" href="javascript:;" onclick="fecharDivMsg(1,0)">[Fechar]</a></h3><p id="conteudoMsg"></p></div>');
    }    
    
    if(!tipo)
        document.getElementById('effectMenssagem').style.background = '#f00'
    
    document.getElementById('tituloMsg').innerHTML   = titulo;
    document.getElementById('conteudoMsg').innerHTML = conteudo;
    
    runEffect(tipo,2000);
}

/***
 * Cria um efeito do tipo "aguarde" sobre uma determinada DIV
 * @param boolean opcao True para mostrar a DIV do tipo "aguarde"
 * @param string divHidden Nome da DIV que sera sobreposta pela DIV do tipo "aguarde"]
 * @param string [msg] Mensagem a ser exibida. O padrão é "processando"
 */
function divAguarde(opcao,divHidden,msg)
{    
    if(!document.getElementById('transparente'))
    {
        if(typeof(msg) == "undefined")
            msg = 'Processando...';
        //Todo layout devera ter a div conteudo, que esta dentro da div araiz
        $('#conteudo').append('<div id="transparente" style="position: absolute;z-index:2;visibility: hidden; width:819px; filter:alpha(opacity=80); opacity:0.8; background-color:#cccccc; -moz-border-radius: 8px; -webkit-border-radius: 8px;border-radius: 8px;"><div id="carregar" align="center" style="position: fixed;width: 819px; color: #fff;background: url(/'+host+'/public/images/sistema/bar_ani_laranja.gif) repeat-x;">'+msg+'</div></div>');
    }
    
    tamanhoDiv = document.getElementById(divHidden).clientHeight;
    //ajuste ao height e Top
    ajusteTop = $('#'+divHidden).position().top;
    borda = document.getElementById(divHidden).style.borderWidth;
    if(!borda)
        borda = '0px';
    
    //retirar o px da borda
    borda = borda.substr(0, borda.length-2);
    borda = parseInt(borda);
    
    ajusteHeight = (2*borda) + tamanhoDiv;
    
    document.getElementById('transparente').style.height = ajusteHeight+'px';
    document.getElementById('transparente').style.top = ajusteTop+'px';    
                
    if(opcao)
    {
        document.getElementById('transparente').style.visibility = '';
        $( "#transparente" ).fadeIn("fast");
    }        
    else
    {$( "#transparente" ).fadeOut("slow");
         setTimeout(function() {
            document.getElementById('transparente').style.visibility = 'hidden';

        }, (500) );
         
    }
}

/***
 * Chama o ajax via JQuery, usando o efeito da função divAguarde()
 * @param strin nomeDiv Nome da DIV, para o efeito divAguarde()
 **/
function ajaxJQuery(nomeDiv)
{
    divAguarde(true,nomeDiv);
    var frm = $('form');        
    $.ajax({
        type: frm.attr('method'),
        url: frm.attr('action'),
        data: frm.serialize(),
        async: true,
        success: function (request,data) {
            //alert('ok');
            if($.trim(request)!='')
                setMsg('ERRO','Erro 1 ao processar, tente novamente mais tarde. Caso o erro persista, entre em contato com a o administrador!<br>'+request+data,0);
            else
                setMsg('Show','Salvo com sucesso!',1);
            divAguarde(false,nomeDiv);
        },
        error: function (request, status, error) {
            //setMsg('ERRO','Erro ao salvar, entre em contato com a o administrador.!'+request.responseText,0);
            setMsg('ERRO','Erro 2 ao processar, tente novamente mais tarde. Caso o erro persista, entre em contato com a o administrador!<br>'+request,0);
            divAguarde(false,nomeDiv);
        }
    });
   

}

/***
 * Função alert() customizada
 * @param string titulo Titulo do alert
 * @param string msg Mensagem do alert
 */
function showAlert(titulo,msg){
    
    if(!document.getElementById('showAlert'))
    {
        var showAlert = document.createElement('div');
        showAlert.id = 'showAlert';    
        document.body.appendChild(showAlert);
    }
    document.getElementById('showAlert').innerHTML = msg;
    document.getElementById('showAlert').title = titulo;
    
    // Utiliza funções do plugin JQueryUI
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

/***
 * Função confirm() customizada
 * @param string titulo Titulo do confirm
 * @param string msg Mensagem do confirm
 * @param string funcao Função chamada ao se confirmar
 * @param array parametros Array com todos os parametros da função
 */
function showAlertConfirm(titulo,msg,funcao,parametros){
    
    if(!document.getElementById('showAlertConfirm'))
    {
        var showAlertConfirm = document.createElement('div');
        showAlertConfirm.id = 'showAlertConfirm';    
        document.body.appendChild(showAlertConfirm);
    }
    
    document.getElementById('showAlertConfirm').innerHTML = msg;
    document.getElementById('showAlertConfirm').title = titulo;
    
    //montar os parametros
    // parametro do tipo x = [ 'p0', 'p1', 'p2' ]; 
    params = '';
    for(i=0;i<parametros.length;i++){
        params += parametros[i]+',';
    }    
    params = params.substr(0, (params.length-1));
    
    funcao = funcao+'('+params+');';
    
    // Utiliza funções do plugin JQueryUI
    $(function() {
        $( "#showAlertConfirm" ).dialog({
            resizable: true,
            height:200,
            modal: true,
            buttons: {
                "Confirma": function() {
                    $( this ).dialog( "close" );
                    
                    eval(funcao);
                    
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    });
    
}

/***
 * Para mais informações vide README.txt
 */
function desmarcaPai()
{
    temp = document.forms[0].getElementsByClassName('idPai');
    if(temp.length)
    { 
        for (i = 0; i < temp.length; i++)
        {   
            temp[i].checked = false;
                
        }
    }
}
    
/***
 * Para mais informações vide README.txt
 */
function marcaPai(pai)
{
    pai = pai.substr(0,pai.indexOf(','));
        
    if(pai==0)
        return 1;
                
    temp = document.forms[0].getElementsByClassName('idPai');
        
    if(temp.length)
    { 
        for (ii = 0; ii < temp.length; ii++)
        {   
            paiAux = temp[ii].value;
            paiAux2 = paiAux.substr(paiAux.indexOf(',')+1);
               
            if(paiAux2==pai)
            {
                temp[ii].checked = true;
                marcaPai(paiAux);
            }    
                
        }
    }
        
}
    
/***
 * Ao marcar diretamente uma funcionalidade, todos os grupos são desmarcados
 */
function setGrupoOff()
{
    temp = document.forms[0].getElementsByClassName('idGrupoTmp');
    if(temp.length)
    { 
        for (i = 0; i < temp.length; i++)
        {   
            temp[i].checked = false;
                
        }
    }
}
    
function apagaArrayIdTempTime()
{
    document.getElementById('arrayIdTempTime').value=',';
}
    
/***
 * Marca no menuTree as funcionalidades do grupo
 */
function setFuncioGrupo()
{
    arrayIdFuncionalidades = "";
    valor = '';
        
    temp = document.forms[0].getElementsByClassName('idGrupoTmp');
    if(temp.length)
    { 
        for (i = 0; i < temp.length; i++)
        {   
            if(temp[i].checked)
            {
                arrayIdFuncionalidades += ','+document.getElementById('arrayIdTempFuncionalidade_'+temp[i].value).value+',';
                arrayIdFuncionalidades = arrayIdFuncionalidades.replace(/^\s+|\s+$/g,"");//retirar espaços em branco
                arrayIdFuncionalidades = arrayIdFuncionalidades.replace(/(\r\n|\n|\r)/gm,"");//retirar "enter"
            }
        }
    }
        
    temp = document.forms[0].getElementsByClassName('idFuncionalidade');
        
    if(temp.length)
    {
        for (i = 0; i < temp.length; i++)
        {
            valor = temp[i].value;
                
            if(existeNaStr(",",valor))
                valor = valor.substr(valor.indexOf(",")+1);
                
            temp[i].checked=false;                 
                
            if(existeNaStr(','+valor+',',arrayIdFuncionalidades))
            {
                temp[i].checked=true;
            }
                
        }
    }
}
    
/***
 * Desabilita/Habilita os checkboxes das funcionalidades Liberar, editar, 
 * deletar, quando existe um grupo e ele é marcado.
 */
function disableLED()
{
    arrayIdFuncionalidades = '';
    aux='';
    temp = document.forms[0].getElementsByClassName('idGrupoTmp');
        
    if(temp.length)
    { 
        for (i = 0; i < temp.length; i++)
        {   
            if(temp[i].checked)
            {    
                arrayIdFuncionalidades = document.getElementById('arrayIdTempFuncionalidade_'+temp[i].value).value;
                arrayIdFuncionalidades = arrayIdFuncionalidades.replace(/^\s+|\s+$/g,"");//retirar espaços em branco
                arrayIdFuncionalidades = arrayIdFuncionalidades.replace(/(\r\n|\n|\r)/gm,"");//retirar "enter"
                arrayIdFuncionalidades = arrayIdFuncionalidades.split(',');
                     
                for (i = 0; i < arrayIdFuncionalidades.length; i++)
                {
                    if(!existeNaStr(arrayIdFuncionalidades[i],aux))
                        aux +=  arrayIdFuncionalidades[i]+',';
                }
                     
            }
        }
    }
    temp = aux.substr(0,aux.length-1);
    temp = temp.split(',');
        
    if(temp.length)
    {
        for (i = 0; i < temp.length; i++)
        {   
            toggleLED(temp[i]);
        }
    }
}
    
/***
 * Chama a função toggleDisabled se a div com o LED existe
 * @param string nomeDiv Nome da div que será desabilitada
 */
function toggleLED(nomeDiv) {
    if(document.getElementById(nomeDiv))
    {
        toggleDisabled(document.getElementById(nomeDiv));
    }
            
}

/***
 * Desabilita/Habilita os checkboxes
 * @param Object el Elemento a ser habilidado ou desabilitado
 */
function toggleDisabled(el) {
    try 
    {
        el.disabled = el.disabled ? false : true;
        //el.checked  = el.checked ? true : false;
        if(el.disabled)
            el.checked  = false;
    }
    catch(E){}

    if (el.childNodes && el.childNodes.length > 0) {
        for (var x = 0; x < el.childNodes.length; x++) {
            toggleDisabled(el.childNodes[x]);
        }
    }
}
    
/******************************************************************************/
//                               INICIO FILTRO
/******************************************************************************/
    
function setFiltroTime()
{
    listaIdEmpresa = document.getElementById('arrayIdTempEmpresa').value;
    listaIdEmpresa = listaIdEmpresa.substr(1,listaIdEmpresa.length-2); //retira a 1º e a ultima virgula
        
    url = urlAjaxTime+'/selecionar/1/listaIdEmpresa/'+listaIdEmpresa;
    ajax(url,'ajax_time');
}

//0 = adicionar, 1= selecionar
selectOrAdd = 0;
//1= gerenciar
gerenciarFuncionario = 0;

//todos de todas as empresas
function setFiltroFuncionario(todos,remover,pagina)
{       
    listaIdFuncionarioEscolhido = document.getElementById('arrayIdTempFuncionarioEscolhido').value;
    listaIdFuncionarioEscolhido = listaIdFuncionarioEscolhido.substr(1,listaIdFuncionarioEscolhido.length-2); //retira a 1º e a ultima virgula
    url = urlAjaxFuncionario+
    '/listaIdFuncionarioEscolhido/'+listaIdFuncionarioEscolhido;
    if (typeof(todos) == "undefined" || todos=='')
    {    
            
        listaIdEmpresa = document.getElementById('arrayIdTempEmpresa').value;
        listaIdEmpresa = listaIdEmpresa.substr(1,listaIdEmpresa.length-2); //retira a 1º e a ultima virgula
        listaIdTime = document.getElementById('arrayIdTempTime').value;
        listaIdTime = listaIdTime.substr(1,listaIdTime.length-2); //retira a 1º e a ultima virgula
            
        idCargo = document.getElementById('id_cargo').value;
        idSetor = document.getElementById('id_setor').value;
        idFuncionario_tipo  = document.getElementById('id_funcionario_tipo').value;
            
        url += '/listaIdEmpresa/'+listaIdEmpresa+
        '/listaIdTime/'+listaIdTime+    
        '/id_cargo/'+idCargo+
        '/id_setor/'+idSetor+
        '/id_funcionario_tipo/'+idFuncionario_tipo;
    }
    else
    {
        url2 = urlAjaxEmpresa+'/selecionar/1';
        document.getElementById('arrayIdTempEmpresa').value = ',';
        ajax(url2,'ajax_empresa');
    }
        
   if ((typeof(pagina) != "undefined") || pagina!=''  )
        url+='/pagina/'+pagina;
        
    if (selectOrAdd == 0)
    {
        ajax(url+'/adicionar/1/','ajax_funcionario');

        if ((typeof(remover) != "undefined") || remover!='' )
        {   
            url += '/remover/1';
            if(document.getElementById('arrayIdTempFuncionarioEscolhido').value != ',')
                ajax(url,'ajax_funcionario_adicionados');
            else
                document.getElementById('ajax_funcionario_adicionados').innerHTML = 'Nenhum item adicionado.';
        }
    }
    else if(selectOrAdd == 1)
        ajax(url+'/selecionar/1/','ajax_funcionario');
    
    if(gerenciarFuncionario == 1)
        ajax(url,'ajax_funcionario');
    
}

function filtraCnpj()
{   
    cnpj = document.getElementById('cnpj').value;
    cnpj = removeCaractere(cnpj);
    if(selectOrAdd != 2)
        url = urlAjaxEmpresa+'/selecionar/1'+'/cnpj/'+cnpj;
    else
        url = urlAjaxEmpresa+'/cnpj/'+cnpj;
    ajax(url,'ajax_empresa');
}
    
function setEmpresasVisiveis(remover,pagina)
{
    listaIdEmpresasEscolhidas = document.getElementById('arrayIdTempEmpresaEscolhida').value;
    listaIdEmpresasEscolhidas = listaIdEmpresasEscolhidas.substr(1,listaIdEmpresasEscolhidas.length-2); //retira a 1º e a ultima virgula
        
    url = urlAjaxEmpresa+'/pagina/'+pagina+
    '/listaIdEmpresasEscolhidas/'+listaIdEmpresasEscolhidas;
    ajax(url+'/adicionar/1','ajax_empresas_visiveis');
        
    if ((typeof(remover) != "undefined")  )
    {   
        url += '/remover/1';
        if(document.getElementById('arrayIdTempEmpresaEscolhida').value != ',')
            ajax(url,'ajax_empresas_adicionadas');
        else
            document.getElementById('ajax_empresas_adicionadas').innerHTML = 'Nenhum item adicionado.';
    }
       
}
    
function setTimesVisiveis(remover,pagina)
{
    listaIdTimesEscolhidos = document.getElementById('arrayIdTempTimeEscolhido').value;
    listaIdTimesEscolhidos = listaIdTimesEscolhidos.substr(1,listaIdTimesEscolhidos.length-2); //retira a 1º e a ultima virgula
        
    url = urlAjaxTime+'/pagina/'+pagina+
    '/listaIdTimesEscolhidos/'+listaIdTimesEscolhidos;
    ajax(url+'/adicionar/1','ajax_times_visiveis');
        
    if ((typeof(remover) != "undefined")  )
    {   
        //alert('asd');
        url += '/remover/1';
        if(document.getElementById('arrayIdTempTimeEscolhido').value != ',')
            ajax(url,'ajax_times_adicionados');
        else
            document.getElementById('ajax_times_adicionados').innerHTML = 'Nenhum item adicionado.';
    }
       
}
    
/******************************************************************************/
//                               FIM FILTRO
/******************************************************************************/
    
/******************************************************************************/
//                               INICIO AJAX
/******************************************************************************/
function getIdFuncionalidade(idGrupo)
{
    url = urlAjaxGrupo+'/selecionar/1/idGrupo/'+idGrupo;
    ajax(url,'ajax_id_funcionalidade');
    document.getElementById('arrayIdTempFuncionalidade_'+idGrupo).value = document.getElementById('ajax_id_funcionalidade').innerHTML;
}
    
tabelas='';

/***
* Como existe mais de um paginator na pagina, temos que ter o controle da
* funcao setPaginator() para que o ajax correto seja carregado.
* Ao passar o mouse sobre cada DIV, essa variavel eh setada
*/ 
function setTabela(tabela)
{
    tabelas = tabela;
}
    
function carregaMenuTree(editar,id_usuario)
{
    url = urlAjaxCarregaMenuTree;
    
    if ((typeof(editar) != "undefined") && editar==1 )
    {
        url +='/editarCA/1/id_usuario/'+id_usuario;
    }
    
    ajax(url,'ajax_funcionalidades');
    //carrega o menu tree
    //http://www.dynamicdrive.com/dynamicindex1/navigate1.htm
    //ddtreemenu.createTree(treeid, enablepersist, opt_persist_in_days (default is 1))
    ddtreemenu.createTree("treemenu1", false);
}
    
    
    /******************************************************************************/
    //                               FIM AJAX
    /******************************************************************************/
    
    
/***
* Faz o submit do formulário quando o usuário aperta a tecla "enter".
*/ 
function submitEnter(myfield,e)
{
    var keycode;
    if (window.event) 
        keycode = window.event.keyCode;
    else if (e) 
         keycode = e.which;
    else 
        return true;

    if (keycode == 13)
    {
        loga();
        return false;
    }
    else
        return true;
}


function loga()
{
    divAguarde(true,'login1');
    email = document.getElementById('login').value;
    senha = document.getElementById('senha').value;

    ajax(url+'/login/'+email+'/senha/'+senha, 'ajax');

    valida = document.getElementById('ajax').innerHTML;

    if(valida == 0)
        showAlert('ERRO', 'Login ou senha incorretos!');
    else
    {
        //Se o login der certo, sera redirecionado para a view "logado", view inical padrao, depois de logado, de TODOS os modulos
        //menos o portal
        if(pathArray[2] == "portal")
            window.location.pathname = redirectEad;
        else
            window.location.pathname = redirect;
    }

    divAguarde(false,'login1');

}

/*****************************************************************************
 *      INICIO DE SCRIPTS PARA VALIDACAO E MASCARAS
 ****************************************************************************/

/**  
 * Função para aplicar máscara em campos de texto
 * Copyright (c) 2008, Dirceu Bimonti Ivo - http://www.bimonti.net 
 * All rights reserved. 
 * @constructor 
 * http://forum.wmonline.com.br/topic/196136-mascara-de-campos/
  * Version 0.27  
  *
  * @param w - O elemento que será aplicado (normalmente this).
  * @param e - O evento para capturar a tecla e cancelar o backspace.
  * @param m - A máscara a ser aplicada.
  * @param r - Se a máscara deve ser aplicada da direita para a esquerda. Veja Exemplos.
  * @param a - 
  * @returns null  
  */
function maskIt(w,e,m,r,a){
        
        // Cancela se o evento for Backspace
        if (!e) var e = window.event
        if (e.keyCode) code = e.keyCode;
        else if (e.which) code = e.which;
        
        // Variáveis da função
        var txt  = (!r) ? w.value.replace(/[^\d]+/gi,'') : w.value.replace(/[^\d]+/gi,'').reverse();
        var mask = (!r) ? m : m.reverse();
        var pre  = (a ) ? a.pre : "";
        var pos  = (a ) ? a.pos : "";
        var ret  = "";

        if(code == 9 || code == 8 || txt.length == mask.replace(/[^#]+/g,'').length) return false;

        // Loop na máscara para aplicar os caracteres
        for(var x=0,y=0, z=mask.length;x<z && y<txt.length;){
                if(mask.charAt(x)!='#'){
                        ret += mask.charAt(x);x++;
                } else{
                        ret += txt.charAt(y);y++;x++;
                }
        }
        
        // Retorno da função
        ret = (!r) ? ret : ret.reverse()        
        w.value = pre+ret+pos;
}

function MascaraCpfCnpj(objeto,evento) 
{
    if (document.getElementById('cpfCnpj').innerHTML == 'CPF')
    {
            maskIt(objeto,evento,'###.###.###-##');
    }
    else
    {
            maskIt(objeto,evento,'##.###.###/####-##');
    }
}

/***
 * valida o CPF digitado
 * @param Object Objcpf  O elemente a ser validado, objeto do tipo text
 */
function ValidarCPF(Objcpf){
	var i; 
  
	s = Objcpf.value; 
	exp = /\.|\-/g
	s = s.toString().replace( exp, "" );
	
	if (s!='')
	{
		if (s.length != 11){ 
		
			showAlert('Erro',"CPF Invalido") 
			
			return false;
		}
		
		var c = s.substr(0,9); 
		
		var dv = s.substr(9,2); 
		
		var d1 = 0; 
		
		for (i = 0; i < 9; i++) 
		
		{ 
		
			d1 += c.charAt(i)*(10-i); 
		
		} 
		
		if (d1 == 0)
		{ 
		
			showAlert('Erro',"CPF Invalido") 
			
			return false; 
		
		} 
		
		d1 = 11 - (d1 % 11); 
		
		if (d1 > 9) d1 = 0; 
		
		if (dv.charAt(0) != d1) 
		{ 
		
			showAlert('Erro',"CPF Invalido") 
			
			return false; 
		
		} 
			
		d1 *= 2; 
		
		for (i = 0; i < 9; i++) 
		
		{ 
		
			d1 += c.charAt(i)*(11-i); 
		
		} 
		
		d1 = 11 - (d1 % 11); 
		
		if (d1 > 9) d1 = 0; 
		
		if (dv.charAt(1) != d1) 
		{ 
		
			showAlert('Erro',"CPF Invalido") 
			
			return false; 
		
		}
		
		if( (s == '11111111111') || (s == '22222222222') || (s == '33333333333') || (s == '44444444444') || (s == '55555555555') || (s == '66666666666') || (s == '77777777777') || (s == '88888888888') || (s == '99999999999') || (s == '00000000000') )
		{
			showAlert('Erro','CPF Invalido!');
			//Objcpf.select();
			return false; 	
		}
	
	}
	
	return true;
       
}

/***
 * valida o CNPJ digitado
 * @param Object ObjCnpj  O elemente a ser validado, objeto do tipo text
 */
function ValidarCNPJ(ObjCnpj){
    var cnpj = ObjCnpj.value;
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
            showAlert('Erro','CNPJ Invalido!');
            //ObjCnpj.select();
            return false;
        }
    }
    
    return true;
}

function ValidaCpfCnpj(data) 
{
    if (document.getElementById('cpfCnpj').innerHTML == 'CPF')
    {
            ValidarCPF(data);
    }
    else
    {
            ValidarCNPJ(data);		
    }
}

//valida telefone
function validaTelefone(tel){
    exp = /\d{4}\-\d{4}/
    if( (tel.value.length != 0) && (!exp.test(tel.value)) )
    {
        showAlert('','Numero de Telefone Invalido!');
    }
}

//valida CEP
function validaCep(cep){
    exp = /\d{2}\.\d{3}\-\d{3}/
    var cep1 = cep.value;
    cep1 = cep1.toString().replace( exp, "" );

    if ( cep1 != '')
    {
        if(!exp.test(cep.value))
        {
            showAlert('Erro','Numero de Cep Invalido!');               
        }
    }
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
     
  if ( !exp.test(email) && email != "")
  {
    showAlert('Erro','E-mail inválido');
    return false;
  }
  
  return true;
}
	
//Valida Senha
function validarSenha(senha)
{
    
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


function colocaMascaraTel(txt){
    if(txt.length>0)
        txt = txt.substr(0,4)+'-'+txt.substr(4,4);
    return txt
}

function colocaMascaraCep(txt){
    if(txt.length>0)
        txt = txt.substr(0,2)+'.'+txt.substr(2,3)+'-'+txt.substr(5,3);
    return txt
}

function colocaMascaraCnpj(txt){
    if(txt.length>0)
        txt = txt.substr(0,2)+'.'+txt.substr(2,3)+'.'+txt.substr(5,3)+'/'+txt.substr(8,4)+'-'+txt.substr(12,2);
    return txt
}

function colocaMascaraCpf(txt){
    //$cpf = substr($cpf, 0,3).'.'.substr($cpf, 3,3).'.'.substr($cpf, 6,3).'-'.substr($cpf, 9,2);
    if(txt.length>0)
        txt = txt.substr(0,3)+'.'+txt.substr(3,3)+'.'+txt.substr(6,3)+'-'+txt.substr(9,2);
    return txt
}

/*****************************************************************************
 *      FIM DE SCRIPTS PARA VALIDACAO E MASCARAS
 ****************************************************************************/

function proximoCampo(atual,proximo)
{
    if(atual.value.length >= atual.maxLength)
    {
        document.getElementById(proximo).focus();
    }
}

function ativaProximo(atual,proximo)
{
    if(atual.value.length >= atual.maxLength)
    { 
        document.getElementById(proximo).readOnly = false;
        document.getElementById(proximo).style.background = '#FFFFFF';
        document.getElementById(proximo).focus();
    }
}

function habilitaSelect(atual,proximo,focu)
{		
    if(atual.value.length >= atual.maxLength)
    { 
        document.getElementById(proximo).disabled = false;
        document.getElementById(proximo).style.background = '#FFFFFF';
        if (focu==1)
            document.getElementById(proximo).focus();
    }
}


function buscaCep(div)
{   
    if(document.getElementById('cep').value == "")
        return true;
        
    divAguarde(true, div,'Aguarde, pesquisando o CEP...');
    $.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").attr('value'), function(){
	
				
        if (resultadoCEP["tipo_logradouro"] != '') {
            if (resultadoCEP["resultado"]) {
                // troca o valor dos elementos
                $("#tipo_logradouro").val(unescape(resultadoCEP["tipo_logradouro"]) + " " + unescape(resultadoCEP["logradouro"]));
                $("#bairro").val(unescape(resultadoCEP["bairro"]));
                $("#cidade").val(unescape(resultadoCEP["cidade"]));
                $("#estado").val(unescape(resultadoCEP["uf"]));
                $("#numero").focus();
                divAguarde(false, div);
            }
        }
        else
        {
            $("#tipo_logradouro").val("");
            $("#bairro").val("");	
            $("#cidade").val("");
            $("#estado").val("RJ");
            divAguarde(false, div);
        }
    });
}

/***
 * Faz uma contagem dos caracteres restantes de um textArea
 * @param string campo id do TextArea a ser contado
 * @param string spam id do Spam, onde o resultado da contagem ficara armazenado
 * @example cadastrarfuncionario
 */
function limiteTxtArea(campo,spam,limite){  
   $("#"+campo+"").limit(limite, '#'+spam+''); 
}

function removeCaractere(valor){
        
    valor = valor.replace(/\//g, ""); //remove a "/"
    valor = valor.replace(/\-/g, ""); //remove o "-"
    valor = valor.replace(/\./g, ""); //remove a "."
    return valor;
    
}

function converteDataMysql(data)
{
    if(data == "")
    {
            return null;
    }

    dia = data.substr(0,2);
    mes = data.substr(3,2);
    ano = data.substr(6,4);

    return ano+'-'+mes+'-'+dia;
}

function converteDataTela(data)
{
    if(data == "0000-00-00")
        return "";

    if(data == "")
        return "";

    ano = data.substr(0,4);
    mes = data.substr(5,2);
    dia = data.substr(8,2);
    
    return dia+'/'+mes+'/'+ano;

}