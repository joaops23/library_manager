function submitClient() { // Insere novo Cliente

    let name = document.getElementById('modalname').value;
    let email = document.getElementById('modalemail').value;
    let phone = document.getElementById('modalphone').value;
    let address = document.getElementById('modaladdress').value;

    //recupera apenas em casos de alteração
    let id = document.getElementById('modalId').value;
    
    if(!name || !email || !phone) { 
        alert("Há campos a serem inseridos antes de inserir novo Cliente")
        return; 
    }

    data = {
        name: name,
        email: email,
        phone: phone,
        address: address
    }

    // A alteração é condicionada ao id não nulo
    if(!id){
        handleRequest('POST', '/clients', data)
    } else {
        handleRequest('PATCH', `/clients/${id}`, data)
    }
}

function deleteClient(id) { //deleta o Cliente referenciando por id
    if(!confirm("Deseja mesmo deletar este Cliente?")) {return ;};

    handleRequest('DELETE', `/clients/${id}`)
    const myModal = new bootstrap.Modal('#modalClient2', {
        keyboard: false,
      })
      myModal.show()
}

function modalUpdateClient(id, name, phone, email, address) {
    document.getElementById('modalClientLabel').innerHTML = `Cliente ${name}`
    document.getElementById('modalname').value = name
    document.getElementById('modalphone').value = phone
    document.getElementById('modalemail').value = email
    document.getElementById('modaladdress').value = address
    document.getElementById('modalId').value = id
}

function clearModal(){
    document.getElementById('modalId').value = '';
    document.getElementById('modalname').value = '';
    document.getElementById('modalphone').value = "";
    document.getElementById('modalemail').value = ""; 
    document.getElementById('modaladdress').value = ""; 
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