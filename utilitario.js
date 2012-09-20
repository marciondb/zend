function preencheCampos()
{
    for (i=0; i<formulario.elements.length; i++) {  
        var fieldValue = formulario.elements[i].value;  
        if(fieldValue == '') {  
            //alert('Campo vazio : '+formulario.elements[i].name);  
            formulario.elements[i].value=formulario.elements[i].name;  

        }  
    }
}


