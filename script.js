
function fetchTasks() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "index.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(xhr.responseText, "text/html");
            const taskList = doc.querySelector("#taskList").innerHTML;
            document.getElementById("taskList").innerHTML = taskList;
        }
    };
    xhr.send();
}

function addTask() {
    const task = document.getElementById("taskInput").value;

    if (!task) {
        alert("Please enter a task!");
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "index.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById("taskInput").value = ""; 
            fetchTasks(); 
        }
    };
    xhr.send("action=add&task=" + encodeURIComponent(task));
}


function deleteTask(id) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "index.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (xhr.status === 200) {
            fetchTasks(); 
        }
    };
    xhr.send("action=delete&id=" + id);
}


window.onload = fetchTasks;
