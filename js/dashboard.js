let usersUL = document.querySelector('#users');

// GET USER DATA
let getData = (URL) => {
    return new Promise((resolve, reject) => {
        //1. creating a new XMLHttpRequest object
        const xhr = new XMLHttpRequest();

        //2. defining the API endpoint
        const url = URL;

        //3. opening a new connection
        xhr.open('GET', url, true);

        //4. on receiving request, process it here:
            xhr.onload = function() {
            //parse API data ito JSON
            const data = JSON.parse(this.response.substring(1));
            resolve(data);
        }

        //5. on error reject
        xhr.onerror = () => reject(xhr.statusText);

        //6. sending the request
        xhr.send();
    });
}

let removeChildNodes = () => {
    //childNodes to be removed -> usersUL
    if(usersUL.hasChildNodes()) {
        while(usersUL.hasChildNodes()){
            usersUL.removeChild(usersUL.firstChild);
        }
    }
}

let updateUsersUI = (data) => {
    for(let i in data){
        let li = document.createElement('li');
        li.innerHTML = (`
                Name: ${data[i].name}
                Score: ${data[i].serial_number}
        `);
        usersUL.appendChild(li);
    }
}


document.addEventListener('DOMContentLoaded', async() => {
    const ctx = document.getElementById('myChart').getContext('2d');
    var xValues = [1,2,3,4,5,6,7,8];
    var yValues = [5,4,3,9,8,10,9,9];

    new Chart("myChart", {
        type: "line",
        data: {
            labels: xValues,
            datasets: [{
            backgroundColor: "rgba(0,0,0,1.0)",
            borderColor: "rgba(0,0,0,0.1)",
            data: yValues,
            tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                display: true,
                text: 'Jane Doe Scores Line Graph'
                },
                legend: {
                    display: false,
                },
            },
            scales: {
                x: {
                display: true,
                title: {
                    display: true,
                    text: 'Month'
                }
                },
                y: {
                display: true,
                title: {
                    display: true,
                    text: 'Score'
                }
                }
            },
        
        }
    
    });

    removeChildNodes();
    try {
        let usersData = await getData(`http://localhost/math_bubbles/api/read.php`);
        let updateUsers = await updateUsersUI(usersData.body);
    }
    catch(err){
        console.log(err);
    }

});