function request(tipo, codigo, produto, quantidade) {
    let url = `http://localhost/CRUD/back/index.php?tipo=${tipo}&`

    if (codigo != undefined) {
        url += `codigo=${codigo}&`;
    }

    if(produto != undefined) {
        url += `produto=${produto}&`;
    }

    if(quantidade != undefined) {
        url += `quantidade=${quantidade}&`;
    }

    fetch(url, { method: 'get' }).then(function(response) {

        if (tipo == 2) { // LISTAR
            return response.json();
        }

    }).then(function (data) {       // handle fullfiled promise
        
        let produtos = data;
        console.log(produtos);

        let table = document.getElementsByTagName('table');

        let rows = "";

        for (let i = 0; i < produtos.length; i++) { // O Problema
            rows += "<tr>"
            +   `<td>${produtos[i].codigo}</td>`
            +   `<td>${produtos[i].produto}</td>`    
            +   `<td>${produtos[i].quantidade}</td>`
            +   "<td>"
            +    "<button class='btn' id='editar'>Editar</button>"
            +    "<button class='btn' id='deletar'>Deletar</button>"
            +    "</td>"
            +   "</tr>"
            
        }

        table[0].innerHTML = ""

        table[0].innerHTML = "<tr>"
        +   "<th>codigo</th>"
        +   "<th>produto</th>"
        +   "<th>quantidade</th>"
        +   "<th>açoes"
        +   "</tr>"
        +   rows;
        
    }).catch(function(error) {      // handle failed promise  
        console.log(error);
    });

    // zera os campos
    document.getElementById('codigo').value = "";
    document.getElementById('produto').value = "";
    document.getElementById('quantidade').value = "";
}

document.getElementById('cadastrar').addEventListener( 'click', () => {
    let produto = document.getElementById('produto').value;
    let quantidade = document.getElementById('quantidade').value;

    request(1, undefined, produto, quantidade);
    request(2, undefined, undefined, undefined);
});
