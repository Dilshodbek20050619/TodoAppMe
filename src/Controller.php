<?php

namespace App;

class Controller
{
    private Todo $todo;

    public function __construct()
    {
        $this->todo = new Todo();
    }

    public function home()
    {
        view('button');
    }

    public function login()
    {
        view('login');
    }

    public function register()
    {
        view('register');
    }


    public function showTodos()
    {
        $user_id = 0;
        if (isset($_SESSION['user']['id'])) {
            $user_id = $_SESSION['user']['id'];
        }
        $todos = $this->todo->get($user_id);
        view('home', ['todos' => $todos]);
    }

    public function updateTodoForm($id)
    {
        $id = (int)$id;
        $task = $this->todo->getById($id);
        view('edit', ['task' => $task]);
    }

    public function updateTodoData($id)
    {
        $id = (int)$id;
        if (isset($_POST['title'], $_POST['due_date'], $_POST['status'])) {
            $this->todo->update($id, $_POST['title'], $_POST['due_date'], $_POST['status']);
        }
        redirect('/todos');
        exit();
    }

    public function storeTodo()
    {

        if (!$_SESSION['user']) {
            redirect('/login');
        }
        if (isset($_POST['title'], $_POST['due_date'], $_POST['status'])) {

            $this->todo->store($_POST['title'], $_POST['due_date'], $_POST['status'], $_SESSION['user']['id']);

        }
        redirect('/todos');
        exit();
    }

    public function deleteTodo($id)
    {
        $id = (int)$id;
        $this->todo->delete($id);
        redirect('/todos');
        exit();
    }

    public function storeUser(): mixed
    {
        if (!empty($_POST['full_name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['repeat_password'])) {
            if ($_POST['password'] != $_POST['repeat_password']) {
                $_SESSION['error_message'][] = 'The passwords do not match';
                redirect('/register');
                exit();
            }
            $user = (new \App\User())->register($_POST['full_name'], $_POST['email'], $_POST['password']);
            if ($user) {
                unset($user['password']);
                unset($_SESSION['error_message']);
                $_SESSION['user'] = $user;
                redirect('/todos');
                exit();
            }
            $_SESSION['error_message'] = 'Bu email band qilingan';
            redirect('/register');
            exit();
        }
        $_SESSION['error_message'][] = 'Hamma maydonlarni to‘ldiring';
        redirect('/register');
        exit();
    }

    public function storeLogin(): void
    {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $user = (new \App\User())->login($_POST['email'], $_POST['password']);

            if ($user) {
                unset($user['password']);
                $_SESSION['user'] = $user;
                unset($_SESSION['error_message']);

                redirect('/todos');
                exit();
            }
            $_SESSION['error_message'] = 'Noto\'g\'ri email yoki parol';
            redirect('/login');
            exit();
        }
        $_SESSION['error_message'][] = 'Email va parolni to\'ldiring';
        redirect('/login');
        exit();
    }

    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        redirect('/login');
    }
}