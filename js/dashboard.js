let studentsTable = document.querySelector('#students');
let email = getCookie("email");
let dbTable = email.replace("@gmail.com", "");

// GET USER DATA
let getData = (URL, trimRes = false) => {
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
            if(!trimRes){
                // const data = JSON.parse(this.response.substring(1));
                const data = this.response;
                resolve(data);
            }else{
                // console.log(this.response);
                // const data = JSON.parse(this.response);
                const data = this.response;
                resolve(data);
            }
        }


        //5. on error reject
        xhr.onerror = () => reject(xhr.statusText);

        //6. sending the request
        xhr.send();
    });
}

// GET COOKIE VALUES BY KEY
function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let cookieArray = decodedCookie.split(';');
    for(let i = 0; i <cookieArray.length; i++) {
      let cookie = cookieArray[i];
      while (cookie.charAt(0) == ' ') {
        cookie = cookie.substring(1);
      }
      if (cookie.indexOf(name) == 0) {
        return cookie.substring(name.length, cookie.length);
      }
    }
    return "";
}

// UPDATE USER UI
let updateStudentsUI = (data) => {
    for(let i in data){
        let tr = document.createElement('tr');
        tr.setAttribute("id", `tr${data[i].id}`);
        
        tr.innerHTML = (`
            <td>${data[i].id}</td>
            <td>${data[i].student_name}</td>
            <button type="submit" name="submit" class="delete" id=${data[i].id} style="float: right;">&nbsp; Remove <i class="fa fa-trash" style="color:#000;"></i></button>
        `);

        studentsTable.appendChild(tr);
    }
}

// DELETE STUDENT RECORD
async function deleteStudent(id) {
    let deleteStudentData = await getData(`http://localhost/math_bubbles/api/delete.php?db_table=${dbTable}&id=${id}`, true);

    if(deleteStudentData == "Registration record deleted."){
        while (studentsTable.lastChild.id !== 'theader') {
            studentsTable.removeChild(studentsTable.lastChild);
        }
        let email = getCookie("email");
        console.log(email);
        let dbTable = email.replace("@gmail.com", "");
        let studentsData = await getData(`http://localhost/math_bubbles/api/read.php?db_table=${dbTable}`);
        let updateStudents = await updateStudentsUI(studentsData.body);
        deleteListen();
    }else{
        console.log(deleteStudentData);
    }
}

// LISTEN FOR DELETE EVENT
function deleteListen(){
    let deleteBtn = document.querySelectorAll('.delete');
    for(let i = 0; i < deleteBtn.length; i++){
        deleteBtn[i].addEventListener('click', event => {
            let currentItem = this.event.currentTarget.closest("button");
            let currentItemID = currentItem.id;
            console.log(`${currentItemID}`);
            deleteStudent(currentItemID);
        });
    }
}


//DRAW CHART
function drawChart(xValues, y1Values, y2Values){
    new Chart("myChart", {
        type: "line",
        data: {
            labels: xValues,
            datasets: [{
            backgroundColor: "rgba(255, 165, 0, 1.0)",
            borderColor: "rgba(255, 165, 0, 0.5)",
            data: y1Values,
            tension: 0.4
            },
            {
                backgroundColor: "rgba(99, 23, 169, 1.0)",
                borderColor: "rgba(99, 23, 169, 0.5)",
                data: y2Values,
                tension: 0.4
            }
        ]
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
                    text: 'Date Time'
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
}

//=================================================================

document.addEventListener('DOMContentLoaded', async() => {

    // const ctx = document.getElementById('myChart').getContext('2d');
    //xValues -> time, y1Values -> level_1, y2Values -> level_2
    
    var xValues = [];
    var y1Values = [];
    var y2Values = [];

    try {
        email = getCookie("email");
        let dbTable = email.replace("@gmail.com", "");
        let studentsData = await getData(`http://localhost/math_bubbles/api/read.php?db_table=${dbTable}`);

        let studentData = await getData(`http://localhost/math_bubbles/api/single_read.php/?db_table=example_78`, true);
        
        let scoreBoardData = await getData(`http://localhost/math_bubbles/api/read_all.php/?db_table=example`);
        console.log(scoreBoardData);
        await studentData.forEach((item)=>{
            // console.log(item);
            xValues.push(item["time"]);
            y1Values.push(item["level_1"]);
            y2Values.push(item["level_2"]);
        });
        performanceChart = drawChart(xValues, y1Values, y2Values);

        let updateStudents = await updateStudentsUI(studentsData.body);
        deleteListen();
    }
    catch(err){
        console.log(err);
    }
    

});