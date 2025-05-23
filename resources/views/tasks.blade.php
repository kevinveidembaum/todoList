<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 40px;
            background-color: #f9f9f9;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        form#newTaskForm {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        form#newTaskForm input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 200px;
        }

        form#newTaskForm button {
            padding: 10px 20px;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form#newTaskForm button:hover {
            background-color: #218838;
        }

        .task {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .task h3 {
            margin-top: 0;
            margin-bottom: 5px;
        }

        .task p {
            margin: 5px 0;
        }

        .task button {
            margin-top: 10px;
            margin-right: 10px;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .task button:first-of-type {
            background-color: #007bff;
            color: white;
        }

        .task button:first-of-type:hover {
            background-color: #0069d9;
        }

        .task button:last-of-type {
            background-color: #dc3545;
            color: white;
        }

        .task button:last-of-type:hover {
            background-color: #c82333;
        }

        .completed {
            background-color: #f0f0f0;
            color: #777;
        }

        .completed h3, .completed p {
            text-decoration: line-through;
        }

        hr {
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <h1>Minhas Tarefas</h1>

    <form id="newTaskForm">
        <input type="text" id="title" placeholder="Título" required>
        <input type="text" id="description" placeholder="Descrição" required>
        <button type="submit">Adicionar Tarefa</button>
    </form>

    <hr>

    <div id="taskList"></div>

    <script>
        const apiUrl = '/api';

        async function fetchTasks() {
            const res = await fetch(`${apiUrl}/index`);
            const tasks = await res.json();

            const container = document.getElementById('taskList');
            container.innerHTML = '';

            tasks.forEach(task => {
                const div = document.createElement('div');
                div.className = 'task';

                if (task.is_completed) div.classList.add('completed');

                div.innerHTML = `
                    <h3>${task.title}</h3>
                    <p>${task.description}</p>
                    <p>Status: ${task.is_completed ? 'Concluída' : 'Pendente'}</p>
                    <button onclick="toggleComplete(${task.id}, ${task.is_completed})">Marcar como ${task.is_completed ? 'Pendente' : 'Concluída'}</button>
                    <button onclick="deleteTask(${task.id})">Excluir</button>
                `;

                container.appendChild(div);
            });
        }

        async function addTask(event) {
            event.preventDefault();

            const title = document.getElementById('title').value;
            const description = document.getElementById('description').value;

            await fetch(`${apiUrl}/new_task`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    title,
                    description,
                    is_completed: false
                })
            });

            document.getElementById('newTaskForm').reset();
            fetchTasks();
        }

        async function deleteTask(id) {
            await fetch(`${apiUrl}/delete_task/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            fetchTasks();
        }

        async function toggleComplete(id, currentStatus) {
            const res = await fetch(`${apiUrl}/index`);
            const tasks = await res.json();
            const task = tasks.find(t => t.id === id);

            if (!task) {
                alert("Tarefa não encontrada.");
                return;
            }

            await fetch(`${apiUrl}/update_task/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    title: task.title,
                    description: task.description,
                    is_completed: !currentStatus
                })
            });

            fetchTasks();
        }

        document.getElementById('newTaskForm').addEventListener('submit', addTask);

        fetchTasks();
    </script>
</body>
</html>

