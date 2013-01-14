README
======

This directory should be used to place project specfic documentation including
but not limited to project notes, generated API/phpdoc documentation, or
manual files generated or hand written.  Ideally, this directory would remain
in your development environment only and should not be deployed with your
application to it's final production location.

REGRAS GERAIS
================

* O sistema está dividido em dois  módulos, o default, o sistema. O módulo default corresponde ao site pf,
o módulo sistema contém a parte administrativa e o módulo EAD é o sistema que é alimentado pelo sistema administrativo.

* O sistema está estruturado em MVC. Todas as models herdam de um arquivo abstrato (fora do Zend) desenvolvido para controlar 
todas as models do sistema, localizado em \pf\application\models\Abstract.php. Neste arquivo foram implementados os métodos save(),
delete() e _validarDados(). Este arquivo é genérico para qualquer tabela que seja utilizada. Outros métodos mais específicos de cada
tabela, foram implementados dentro de suas models. Sempre que é feita uma alteração no sistema, é chamado o método saveLog().

* Assim como nas models, existe um arquivo abstrato (fora do Zend) desenvolvido para controlar 
todas as controladoras do sistema, localizado em \pf\library\Controller\Action.php. Este arquivo possui o método possuiPermissao(), 
que é chamado sempre que uma ação é executada no sistema, seja ajax, cliques, etc. O controle para verificar se o usuário possui permissão para
acessar determinada action está no init desta classe.

* O arquivo \pf\library\Plugins\Layout.php permite a utilização de um layout por módulo.

* O arquivo \pf\application\modules\default\views\scripts\paginator.phtml possui o paginator que faz qualquer tipo de paginação ajax.

* Todos os arquivos de imagens, scripts e css estão na pasta public.

* Toda nome de action ajax deve começar com ajax.
* Todo ajax não eh uma funcionalidade do sistema, por isso não eh validado (esse eh o pq da nomenclatura)
* Toda view que tiver ajax e este ajax usar o paginator, a view obrigatoriamente deve ter a funcao JS setPaginator()

* Controle de Acesso
    O controle de acesso é feito da seguinte forma:
    - Toda funcionalidade tem uma funcionalidade pai. A funcionalidade pai igual a 0, significa 
    que pertence a raiz do menu, ou seja, não tem pai!
    - Sempre que uma funcionalidade for liberada, a funcionalidade pai tem que ser liberada, 
    ate chegar a funcionalidade pai 0.
    - Cada funcionalidade tem 3 outras funcionalidades, que são o EDITAR | DELETAR | LIBERAR, podendo 
    ser ou não preenchidas com funcionalidades. Caso não seja, o valor padrao eh zero.
    Caso tenha uma dessas 3 funcionalidade, cada uma delas deve ser uma nova funcionalidade, 
    com o EDITAR | DELETAR | LIBERAR iguais a zero.
    Ex:
    Liberei o "Gerenciar funcionario", por exemplo, id_funcionalidade igual a 122 e dei 
    permissao de editar (123) e deletar (124)
    Logo, ficaria da seguinte forma:

     ID_FUNCIONALIDADE | EDITAR | DELETAR | LIBERAR
            122        |   123  |   124   |    0
            123        |    0   |    0    |    0
            124        |    0   |    0    |    0



ERROS
===========================
* Erro 171 - qualquer tentativa de fraude ao sistema


Setting Up Your VHOST
=====================

The following is a sample VHOST you might want to consider for your project.

<VirtualHost *:80>
   DocumentRoot "C:/xampp/htdocs/pf/public"
   ServerName .local

   # This should be omitted in the production environment
   SetEnv APPLICATION_ENV development

   <Directory "C:/xampp/htdocs/pf/public">
       Options Indexes MultiViews FollowSymLinks
       AllowOverride All
       Order allow,deny
       Allow from all
   </Directory>

</VirtualHost>
