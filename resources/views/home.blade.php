<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <title>API Laravel de Livros</title>
    </head>
    <body>
        <div class="row" style="margin-top: 5%;">
            <div class="col-10 mx-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Autor</th>
                            <th scope="col">Data de Publicação</th>
                            <th scope="col">Editora</th>
                            <!-- <th scope="col">Editar</th>
                            <th scope="col">Deletar</th> -->
                        </tr>
                    </thead>
                    <tbody id="tabela">
                    </tbody>
                </table>
                <div id="botoes">
                </div>
            </div>
        </div>

        <script type="text/javascript">
            const consultar = (link) => {
                const tabela = document.getElementById("tabela");
                while (tabela.firstChild){
                    tabela.removeChild(tabela.lastChild);
                }

                const botoesDiv = document.getElementById("botoes");
                while (botoesDiv.firstChild){
                    botoesDiv.removeChild(botoesDiv.lastChild);
                }

                let request = new XMLHttpRequest();

                request.onreadystatechange = () => {
                    if (request.readyState == XMLHttpRequest.DONE){
                        if (request.status >= 200 && request.status < 300) {
                            const resposta = JSON.parse(request.responseText);

                            resposta.data.forEach(registro => {
                                const tr = document.createElement("tr");

                                const id = document.createElement("td");
                                const idText = document.createTextNode(registro.id);
                                id.appendChild(idText);
                                tr.appendChild(id);

                                const titulo = document.createElement("td");
                                const tituloText = document.createTextNode(registro.titulo);
                                titulo.appendChild(tituloText);
                                tr.appendChild(titulo);

                                const autor = document.createElement("td");
                                const autorText = document.createTextNode(registro.autor);
                                autor.appendChild(autorText);
                                tr.appendChild(autor);

                                const data_publi = document.createElement("td");
                                let data_publiText = document.createTextNode("");
                                if(registro.data_publi !== null)
                                    data_publiText = document.createTextNode(registro.data_publi);
                                data_publi.appendChild(data_publiText);
                                tr.appendChild(data_publi);

                                const editora = document.createElement("td");
                                let editoraText = document.createTextNode("");
                                if(registro.editora !== null)
                                    editoraText = document.createTextNode(registro.editora);
                                editora.appendChild(editoraText);
                                tr.appendChild(editora);

                                tabela.appendChild(tr);
                            });

                            if(resposta.prev_page_url){
                                const botaoAnterior = document.createElement("button");
                                const botaoAnteriorText = document.createTextNode("Anterior");
                                botaoAnterior.appendChild(botaoAnteriorText);
                                botaoAnterior.onclick = () => {consultar(resposta.prev_page_url)};
                                botoesDiv.appendChild(botaoAnterior);
                            }

                            if(resposta.next_page_url){
                                const botaoProximo = document.createElement("button");
                                const botaoProximoText = document.createTextNode("Próximo");
                                botaoProximo.appendChild(botaoProximoText);
                                botaoProximo.onclick = function() {consultar(resposta.next_page_url)};
                                botoesDiv.appendChild(botaoProximo);
                            }
                        }
                        else {
                            console.log("Erro");
                        }
                    }
                }

                request.open("GET", link);
                request.send();
            }

            window.addEventListener("load", consultar("http://localhost:8000/api/livros"));
        </script>
    </body>
</html>