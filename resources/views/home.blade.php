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
                <button
                    type="button"
                    class="btn btn-primary"
                    id="trocar"
                    onclick="trocar()"
                >Ver Enciclopédias</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" id="nome">Título</th>
                            <th scope="col" id="autor">Autor</th>
                            <th scope="col">Data de Publicação</th>
                            <th scope="col">Editora</th>
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

                                if(link.includes("livros")){
                                    const titulo = document.createElement("td");
                                    const tituloText = document.createTextNode(registro.titulo);
                                    titulo.appendChild(tituloText);
                                    tr.appendChild(titulo);

                                    const autor = document.createElement("td");
                                    const autorText = document.createTextNode(registro.autor);
                                    autor.appendChild(autorText);
                                    tr.appendChild(autor);
                                }

                                if (link.includes("enciclopedia")){
                                    const edicao = document.createElement("td");
                                    const edicaoText = document.createTextNode(registro.edicao);
                                    edicao.appendChild(edicaoText);
                                    tr.appendChild(edicao);
                                }

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
                                if(link.includes("livro"))
                                    botaoAnterior.classList.add("btn-primary");
                                else
                                    botaoAnterior.classList.add("btn-secondary");
                                botaoAnterior.classList.add("btn");
                                botaoAnterior.onclick = () => {consultar(resposta.prev_page_url)};
                                botoesDiv.appendChild(botaoAnterior);
                            }

                            if(resposta.next_page_url){
                                const botaoProximo = document.createElement("button");
                                const botaoProximoText = document.createTextNode("Próximo");
                                botaoProximo.appendChild(botaoProximoText);
                                if(link.includes("livro"))
                                    botaoProximo.classList.add("btn-primary");
                                else
                                    botaoProximo.classList.add("btn-secondary");
                                botaoProximo.classList.add("btn");
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

            const botaoTrocar = document.getElementById("trocar");
            const autor = document.getElementById("autor");
            const nome = document.getElementById("nome");

            const trocar = () => {
                console.log("Clicou");
                if(botaoTrocar.classList.contains("btn-primary")){
                    botaoTrocar.classList.remove("btn-primary");
                    botaoTrocar.classList.add("btn-secondary");
                    botaoTrocar.innerText = "Ver Livros";
                    autor.style.display = "none";
                    nome.innerText = "Edição";
                    consultar("http://localhost:8000/api/enciclopedias");
                }
                else if(botaoTrocar.classList.contains("btn-secondary")){
                    botaoTrocar.classList.remove("btn-secondary");
                    botaoTrocar.classList.add("btn-primary");
                    botaoTrocar.innerText = "Ver Enciclopédias";
                    autor.style.display = "table-cell";
                    nome.innerText = "Título";
                    consultar("http://localhost:8000/api/livros");
                }
            }
        </script>
    </body>
</html>