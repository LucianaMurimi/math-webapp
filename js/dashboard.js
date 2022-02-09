let studentsTable = document.getElementById('students');
let scoreboardTable = document.getElementById('scoreboard');
let studentsBtn = document.getElementById('students-id');
let scoreboardBtn = document.getElementById('scoreboard-id');
let studentsView = document.getElementById('students-table')
let scoreboardView = document.getElementById('students-scoreboard');

let email = getCookie("email");
let dbTable = email.replace("@gmail.com", "");
let firstStudentID;
let currentStudentName;

let scoreBoardData;
let allStudentsData;

// xValues -> time, y1Values -> level_1, y2Values -> level_2
var ctx = document.getElementById('myChart').getContext('2d');   
var performanceGraph;
let xValues = [];
let y1Values = [];
let y2Values = [];

//=================================================================
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

//=================================================================
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
            const data = JSON.parse(this.response);
            resolve(data);
        }

        //5. on error reject
        xhr.onerror = () => reject(xhr.statusText);

        //6. sending the request
        xhr.send();
    });
}

//=================================================================
// DELETE STUDENT RECORD
async function deleteStudent(id) {
    let deleteStudentData = await getData(`http://localhost/math_bubbles/api/delete.php?db_table=${dbTable}&id=${id}`);

    if(deleteStudentData == "Registration record deleted."){
        let newScoreboardData =  scoreBoardData.body.filter((item)=>{
            return item.id != id;
        });
        // console.log(newScoreboardData);

        while (studentsTable.lastChild.id !== 'theader') {
            studentsTable.removeChild(studentsTable.lastChild);
        }
        while (scoreboardTable.lastChild.id !== 'scoreboard-theader') {
            scoreboardTable.removeChild(scoreboardTable.lastChild);
        }

        let studentsData = await getData(`http://localhost/math_bubbles/api/read.php?db_table=${dbTable}`);
        let updateStudents = updateStudentsUI(studentsData.body);
        deleteListen();
        updateScoreboardUI(newScoreboardData);
    }else{
        console.log(deleteStudentData);
    }
}

//=================================================================
// LISTEN FOR DELETE EVENT
function deleteListen(){
    let deleteBtn = document.querySelectorAll('.delete');
    for(let i = 0; i < deleteBtn.length; i++){
        deleteBtn[i].addEventListener('click', event => {
            let currentItem = this.event.currentTarget.closest("button");
            let currentItemID = currentItem.id;
            // console.log(`${currentItemID}`);
            deleteStudent(currentItemID);   //call deleteStudent Function and pass that particular ID
        });
    }
}

//=================================================================
// LISTEN FOR VIEW EVENT
function viewListen(){
    let viewBtn = document.querySelectorAll('.view');
    for(let i = 0; i < viewBtn.length; i++){
        viewBtn[i].addEventListener('click', event => {
            let currentItem = this.event.currentTarget.closest("button");
            let currentItemID = currentItem.id;
            console.log(`${currentItemID}`);
            viewStudentChart(currentItemID);   //call viewStudentChart Function and pass that particular ID
        });
    }
}

async function viewStudentChart(studentID){
    xValues = [];
    y1Values = [];
    y2Values = [];

    await fetchPerformanceData(studentID);

    let currentStudent =  scoreBoardData.body.filter((item)=>{
        return item.id === studentID;
    });
    currentStudentName = currentStudent[0].student_name;
    console.log(currentStudentName);

    performanceGraph.destroy();
    performanceChart = drawChart(xValues, y1Values, y2Values);
}

//=================================================================
//DRAW PERFORMANCE CHART
function drawChart(xValues, y1Values, y2Values){
    performanceGraph = new Chart(ctx, {
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
                text: `${currentStudentName} Scores Performance Graph`
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

async function fetchPerformanceData(studentID){
    let studentDbTable = dbTable.concat(`_${studentID}`);
    // console.log(studentDbTable);
    let studentData = await getData(`http://localhost/math_bubbles/api/single_read.php/?db_table=${studentDbTable}`);
    // console.log(studentData.body);
    await studentData.body.forEach((item)=>{
        xValues.push(item["time"]);
        y1Values.push(item["level_1"]);
        y2Values.push(item["level_2"]);
    });
}

//=================================================================
// UPDATE USER UI
function updateStudentsUI(data) {
    // console.log(data);
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

function updateScoreboardUI(data) {
    firstStudentID = data[0].id;
    currentStudentName = data[0].student_name;

    for(let i in data){
        let tr = document.createElement('tr');
        tr.setAttribute("id", `tr${data[i].id}`);
        
        tr.innerHTML = (`
            <td>${data[i].id}</td>
            <td>${data[i].student_name}</td>
            <td>${data[i].level_one}</td>
            <td>${data[i].level_two}</td>
            <td>${data[i].total_score}</td>
            <button type="submit" name="submit" class="view" id=${data[i].id} style="float: right;">&nbsp; View </button>
        `);
        scoreboardTable.appendChild(tr);
    }
}

function displayStudents(isDisplayStudents){
    if(isDisplayStudents){
        studentsView.classList.remove("hide");
        scoreboardView.classList.add("hide");
    }else{
        studentsView.classList.add("hide");
        scoreboardView.classList.remove("hide");
    }
}

//=================================================================
//ON DOCUMENT LOAD:
//      1. Fetch ScoreBoard Data
//      2. Update UI
//      3. Fetch Performance Chart Data
//      4. Draw Chart
//      5. Fetch Student Data
//      6. Update UI
//      7. Listen for Delete Events
document.addEventListener('DOMContentLoaded', async() => {
    try {
        //      Fetch All Student Data
        allStudentsData = await getData(`http://localhost/math_bubbles/api/read.php?db_table=${dbTable}`);
        let updateAllStudentsUI = updateStudentsUI(allStudentsData.body);
        console.log(allStudentsData);
        deleteListen();
        //      1. Fetch ScoreBoard Data
        scoreBoardData = await getData(`http://localhost/math_bubbles/api/read_all.php/?db_table=${dbTable}`);
        // console.log(scoreBoardData);
        //      2. Update UI
        updateScoreboardUI(await scoreBoardData.body.sort((a, b) => b.total_score - a.total_score));
        //---------------------------------------------------------
        //      3. Fetch Performance Chart Data
        await fetchPerformanceData(firstStudentID);
        //      4. Draw Chart
        performanceChart = drawChart(xValues, y1Values, y2Values);

        //---------------------------------------------------------
        viewListen();
        //---------------------------------------------------------
        //      5. Fetch Student Data
        // allStudentsData = await getData(`http://localhost/math_bubbles/api/read.php?db_table=${dbTable}`);
        // let updateAllStudentsUI = updateStudentsUI(allStudentsData.body);
        // console.log(updateAllStudentsUI);
        // deleteListen();
    }
    catch(err){
        console.log(err);
    }
    studentsView.classList.add("hide");
});