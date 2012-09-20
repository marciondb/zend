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
	
function FecharDivMsg()
{

    $("#mensagem").css("display", "none");
}
        
        /**
         * Função javascript para ser utilizada junto a função transmissor msg da classe ZendUtils, precisa do plugin jquery
         */
function ExibirMsg(id, msg, tipo,tempo)
{

    if(tempo <= 0)
    {       jQuery(id).html(jQuery(id).html()+msg).removeClass().addClass(tipo).fadeIn("fast");
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
