
const form = document.querySelector("#messageForm");

function sendMessage(event){
    event.preventDefault();

    
    const apiKey = document.querySelector("#apiKey").value;
    const number = document.querySelector("#number").value;
    const message = document.querySelector('#eventDescription').value;


    const parameters = {
        apiKey,
        number,
        message
       
    }
    fetch('https://api.semaphore.co/api/v4/messages' , {
        method : 'POST',
        headers:{
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams(parameters)

    }).then(response => response.text())
    .then(output => {
        console.log(output)
    })
    .catch(error => {
        console.error(error)
    })
    form.reset();
}
form.addEventListener('submit', sendMessage);