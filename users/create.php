<?php

$pageTitle = "Add User";

require_once "../config/database.php";
require_once "../includes/header.php";
require_once "../includes/navbar.php";
require_once "../includes/sidebar.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $email    = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("
        INSERT INTO users
        (username, email, password)
        VALUES (?, ?, ?)
    ");

    $stmt->bind_param(
        "sss",
        $username,
        $email,
        $password
    );

    $stmt->execute();

    header("Location: index.php?success=add");
    exit;
}

?>

<div class="container-fluid">

    <h2 class="mb-4">

        <i class="bi bi-person-plus-fill"></i>

        Add User

    </h2>

    <div class="card">

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">

                    <label class="form-label">

                        Username

                    </label>

                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Email

                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Password

                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required>

                </div>

                <button
                    class="btn btn-primary">

                    <i class="bi bi-floppy"></i>

                    Save

                </button>

                <a
                    href="index.php"
                    class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>

<?php

require_once "../includes/footer.php";

?>