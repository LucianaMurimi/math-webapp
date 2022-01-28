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

document.addEventListener('DOMContentLoaded', () => {
    const signUpForm = document.querySelector('form')
    
    signUpForm.addEventListener('submit', (e) => {
        e.preventDefault();
        window.location.href = "dashboard.html";
        async function users() {
            try {
                let data = await getData(`http://localhost/math_bubbles/api/read.php`);
                console.log(data.body);
            }
            catch(err){
                console.log(err);
            }
        }

        users();
        
    })
});