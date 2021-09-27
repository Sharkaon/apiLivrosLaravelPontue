API de Livros feita em Laravel para processo seletivo da Pontue.  

-> A aplicação assume que esteja em localhost na porta 8000 com URL padrão http://localhost:8000, caso seja rodado em outro ambiente, recomenda-se que se altere essa informação no arquivo .env;  

-> As configurações do Banco de Dados podem ser alteradas no arquivo .env, mas por padrão são:  
    Conexão: MySQL  
    Host: 127.0.0.1  
    Nome do banco: apilivroslaravel  
    Nome de Usuário: root  
    Senha:    (vazia)  


Para testar a API, o recomendado é:  
1- Instalar as dependências de composer.json (composer install);  
2- Realizar as migrações (php artisan migrate);  
3- Rodar os seeders (php artisan db:seed);  
4- Hospedar em localhost como padrão do Laravel (php artisan serve);  
5- Importar a coleção de testes (API Livros.postman_collection.json) para o POSTMAN;  
6- Rodar os testes da coleção na ordem em que estão mostrados (pastas Auth -> Livros -> Enciclopedias);  
6.1- Após rodar o primeiro teste de Auth, salvar o token retornado como valor atual da variável de coleção do Postman {{token}};  
  
-> Também é possível visualizar uma tabela com os resultados paginados no link de onde a aplicação está hosteada (http://localhost:8000 por padrão), porém não é possível interagir com os dados.