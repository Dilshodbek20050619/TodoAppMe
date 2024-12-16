<nav class="navbar">
    <ul class="navbar-list">
        <li class="nav-item"><a class="nav-link" href="/">Home</a></li>

        <?php
        if (isset($_SESSION['user'])) :
            ?>

            <li class="dropdown">
                <a href="/todos" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                         class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path fill-rule="evenodd"
                              d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>
                    Profil</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/todos">To-do List</a></li>
                    <li><a class="dropdown-item" href="/todos"><?= $_SESSION['user']['full_name'] ?? '' ?></a></li>
                    <li><a class="dropdown-item" href="/todos"><?= $_SESSION['user']['email'] ?? '' ?></a></li>
                    <form action="/logout" method="POST" class="d-inline">
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </ul>
            </li>
        <?php
        else:
            ?>
            <li class="nav-item"><a class="nav-link" href="/login">Log in</a></li>
            <li class="nav-item"><a class="btn btn-primary" href="/register">Register</a></li>
        <?php
        endif;
        ?>
    </ul>
</nav>

<style>
    .navbar {
        background-color:#000053;
        color: white;
        padding: 10px 20px;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
    }

    .navbar-list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: flex-start;
    }

    .navbar-list li {
        margin-right: 15px;
    }

    .navbar-list li a {
        text-decoration: none;
        color: white;
        padding: 8px 12px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .navbar-list li a:hover {
        background-color: #17565e;
    }

    .navbar-list li a.active {
        background-color: #17565e;
    }

    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .main-content {
        padding-top: 60px;
    }

    .dropdown-menu {
        background-color: #444444;
        color: white;
        text-align: center;
    }

    .dropdown-menu .btn {
        margin-top: 10px;
    }
</style>
