function submitLocation() { // Insere nova Locação
    
    let client = document.getElementById('modalclient').value;
    let book = document.getElementById('modalbook').value;
    let term = document.getElementById('modalterm').value;

    //recupera apenas em casos de alteração
    let id = document.getElementById('modalId').value;
    
    if(!client || !book || !term || parseInt(term) == 0) { 
        alert("Há campos a serem inseridos antes de inserir nova Locação")
        return; 
    }

    data = {
        client_id: client,
        book_id: book,
        term: term
    }
    data.locationDate = new Date().getTime(); // Timestamp
    handleRequest('POST', '/locations', data)
}

function deleteLocation(id) { //deleta o Locação referenciando por id
    if(!confirm("Deseja mesmo deletar este Locação?")) {return ;};

    handleRequest('DELETE', `/locations/${id}`)
    window.location.reload();
}

function clearModal(){
    document.getElementById('modalId').value = '';
    document.getElementById('modalLocation').value = '';
    document.getElementById('modalbook').value = '';
    document.getElementById('modalterm').value = 0; 
}


function devolution(id){
    if(!confirm('Deseja confirmar a devolução do livro alocado?')){ return; }
    handleRequest('put', `/locations/devolution/${id}`)
    const myModal = new bootstrap.Modal('#modalLocation2', {
        keyboard: false,
      })
      myModal.show()
}

const handleRequest = (type, url, data = '') =>{
    //ajax
    $.ajax({
        type: type,
        url: url,
        data: data,
        success: function(data) {
            let responseDiv = document.getElementById('response');
            responseDiv.innerHTML = data;
        },
        error: function(error) {
            let responseDiv = document.getElementById('response');
            responseDiv.innerHTML = error;
        }
    })
}