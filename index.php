<?php

$tasksFile = "tasks.json";

if (!file_exists($tasksFile)) {
    file_put_contents($tasksFile, json_encode([]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['action']) && $_POST['action'] === "add" && !empty($_POST['task'])) {
        $task = htmlspecialchars($_POST['task']);
        $tasks = json_decode(file_get_contents($tasksFile), true);
        $tasks[] = $task;
        file_put_contents($tasksFile, json_encode($tasks));
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] === "delete" && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $tasks = json_decode(file_get_contents($tasksFile), true);
        if (isset($tasks[$id])) {
            unset($tasks[$id]);
            $tasks = array_values($tasks);
            file_put_contents($tasksFile, json_encode($tasks));
        }
        exit;
    }
}

$tasks = json_decode(file_get_contents($tasksFile), true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP To-Do List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>PHP To-Do List</h1>

    <input type="text" id="taskInput" placeholder="Enter a task">
    <button onclick="addTask()">Add Task</button>

    <h2>Tasks</h2>
    <ul id="taskList">
        <?php foreach ($tasks as $id => $task): ?>
            <li>
                <?= htmlspecialchars($task) ?>
                <button onclick="deleteTask(<?= $id ?>)">Delete</button>
            </li>
        <?php endforeach; ?>
    </ul>

    <script src="script.js"></script>
</body>
</html>
