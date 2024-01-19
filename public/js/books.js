function submitBook() { // Insere novo livro
    // resgata o título, autor e descrição do livro
    let title = document.getElementById('modalTitle').value;
    let author = document.getElementById('modalAuthor').value;
    let description = document.getElementById('modalDescription').value;

    //recupera apenas em casos de alteração
    let id = document.getElementById('modalId').value;
    
    if(!title || !author || !description) { 
        alert("Há campos a serem inseridos antes de inserir novo livro")
        return; 
    }

    data = {
        title: title,
        author: author,
        description: description
    }

    // A alteração é condicionada ao id não nulo
    if(!id){
        handleRequest('POST', '/books', data)
    } else {
        handleRequest('PATCH', `/books/${id}`, data)
    }
}

function deleteBook(id) { //deleta o livro referenciando por id
    if(!confirm("Deseja mesmo deletar este livro?")) {return ;};

    handleRequest('DELETE', `/books/${id}`)
}

function modalUpdateBook(id, title, description, author) {
    document.getElementById('modalBookLabel').innerHTML = `Livro ${title}`
    document.getElementById('modalTitle').value = title
    document.getElementById('modalDescription').value = description
    document.getElementById('modalAuthor').value = author
    document.getElementById('modalId').value = id
}

function handleRequest(type, url, data = ''){
    //ajax
    $.ajax({
        type: type,
        url: url,
        data: data,
        success: function(data) {
            let responseDiv = document.getElementById('response');
            responseDiv.innerHTML = data;
            window.location.reload();
        },
        error: function(error) {
            let responseDiv = document.getElementById('response');
            responseDiv.innerHTML = error;
        }
    })
}

function clearModal(){
    document.getElementById('modalId').value = '';
    document.getElementById('modalTitle').value = '';
    document.getElementById('modalDescription').value = "";
    document.getElementById('modalAuthor').value = ""; 
}