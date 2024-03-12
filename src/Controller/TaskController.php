<?php 
namespace App\Todolist\Controller;

use App\Todolist\Repository\TaskRepository;
use App\Todolist\Service\Database;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TaskController extends AbstractController
{
    public function index()
    {
        $taskRepository = new TaskRepository();
        $tasks = $taskRepository->index();
        $this->render('taskpage.twig', [
            'tasks' => $tasks
        ]);
    }

    public function new(){

        if ($_SERVER['REQUEST_METHOD'] === "POST"){
            $taskrepository = new TaskRepository();
            $taskrepository->add();

            // rediriger vers la liste des tâches
            header("Location: http://localhost/todo_list/public/task/");
        }

        $this->render('taskNewPage.twig', []);
    }

    public function show(int $id)
    {
        $taskRepository = new TaskRepository();
        $task = $taskRepository->find($id);       
        
        $this->render('taskDetailPage.twig', [
            'task' => $task
        ]);
    }
    
    public function delete(int $id)
    {
        $taskRepository = new TaskRepository();
        $taskRepository->remove($id);

        // rediriger vers la liste des tâches
        header("Location: http://localhost/todo_list/public/task/");
    }

    public function update(int $id)
    {
        $taskRepository = new TaskRepository();
        $task = $taskRepository->find($id);

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            // récupérer les datas
            $title = $_POST['title'];
            $status = $_POST['status'];
            $taskRepository->update($id, $title, $status);

            // rediriger vers la liste des tâches
            header("Location: http://localhost/todo_list/public/task/");
        }

        $this->render('taskUpdatePage.twig', [
            'task' => $task,
            'optionList' => ["En attente", "terminée"]
        ]);
    }
}