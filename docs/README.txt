README
======

This directory should be used to place project specfic documentation including
but not limited to project notes, generated API/phpdoc documentation, or
manual files generated or hand written.  Ideally, this directory would remain
in your development environment only and should not be deployed with your
application to it's final production location.

REGRAS GERAIS
================

* O sistema está dividido em três módulos, o default, o sistema e o EAD. O módulo default corresponde ao site Pinhonline,
o módulo sistema contém a parte administrativa e o módulo EAD é o sistema que é alimentado pelo sistema administrativo.

* O sistema está estruturado em MVC. Todas as models herdam de um arquivo abstrato (fora do Zend) desenvolvido para controlar 
todas as models do sistema, localizado em \pinho\application\models\Abstract.php. Neste arquivo foram implementados os métodos save(),
delete() e _validarDados(). Este arquivo é genérico para qualquer tabela que seja utilizada. Outros métodos mais específicos de cada
tabela, foram implementados dentro de suas models. Sempre que é feita uma alteração no sistema, é chamado o método saveLog().

* Assim como nas models, existe um arquivo abstrato (fora do Zend) desenvolvido para controlar 
todas as controladoras do sistema, localizado em \pinho\library\Controller\Action.php. Este arquivo possui o método possuiPermissao(), 
que é chamado sempre que uma ação é executada no sistema, seja ajax, cliques, etc. O controle para verificar se o usuário possui permissão para
acessar determinada action está no init desta classe.

* O arquivo \pinho\library\Plugins\Layout.php permite a utilização de um layout por módulo.

* O arquivo \pinho\application\modules\default\views\scripts\paginator.phtml possui o paginator que faz qualquer tipo de paginação ajax.

* Todos os arquivos de imagens, scripts e css estão na pasta public.

Setting Up Your VHOST
=====================

The following is a sample VHOST you might want to consider for your project.

<VirtualHost *:80>
   DocumentRoot "C:/xampp/htdocs/pinho/public"
   ServerName .local

   # This should be omitted in the production environment
   SetEnv APPLICATION_ENV development

   <Directory "C:/xampp/htdocs/pinho/public">
       Options Indexes MultiViews FollowSymLinks
       AllowOverride All
       Order allow,deny
       Allow from all
   </Directory>

</VirtualHost>
