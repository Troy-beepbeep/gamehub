<?php

$pageTitle = "Dashboard";

require_once 'config/database.php';
require_once 'includes/header.php';
require_once 'includes/navbar.php';
require_once 'includes/sidebar.php';

/*
|--------------------------------------------------------------------------
| Total Users
|--------------------------------------------------------------------------
*/

$result = $conn->query("SELECT COUNT(*) AS total FROM users");
$totalUsers = $result->fetch_assoc()['total'];

/*
|--------------------------------------------------------------------------
| Total Games
|--------------------------------------------------------------------------
*/

$result = $conn->query("SELECT COUNT(*) AS total FROM games");
$totalGames = $result->fetch_assoc()['total'];

/*
|--------------------------------------------------------------------------
| Total Reviews
|--------------------------------------------------------------------------
*/

$result = $conn->query("SELECT COUNT(*) AS total FROM reviews");
$totalReviews = $result->fetch_assoc()['total'];

/*
|--------------------------------------------------------------------------
| Total Library
|--------------------------------------------------------------------------
*/

$result = $conn->query("SELECT COUNT(*) AS total FROM game_library");
$totalLibrary = $result->fetch_assoc()['total'];

?>

<div class="container-fluid">

    <h2 class="mb-2">
        <i class="bi bi-speedometer2"></i>
        Dashboard
    </h2>

    <p class="text-muted mb-4">
        Welcome to GameHub Database Management System
    </p>

    <div class="row g-4">

        <!-- Users -->
        <div class="col-lg-3 col-md-6">

            <div class="card shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6 class="text-secondary">
                                Total Users
                            </h6>

                            <h2>
                                <?= $totalUsers ?>
                            </h2>

                        </div>

                        <i class="bi bi-people-fill fs-1 text-primary"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- Games -->
        <div class="col-lg-3 col-md-6">

            <div class="card shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6 class="text-secondary">
                                Total Games
                            </h6>

                            <h2>
                                <?= $totalGames ?>
                            </h2>

                        </div>

                        <i class="bi bi-controller fs-1 text-success"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- Reviews -->
        <div class="col-lg-3 col-md-6">

            <div class="card shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6 class="text-secondary">
                                Total Reviews
                            </h6>

                            <h2>
                                <?= $totalReviews ?>
                            </h2>

                        </div>

                        <i class="bi bi-star-fill fs-1 text-warning"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- Library -->
        <div class="col-lg-3 col-md-6">

            <div class="card shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6 class="text-secondary">
                                Total Library
                            </h6>

                            <h2>
                                <?= $totalLibrary ?>
                            </h2>

                        </div>

                        <i class="bi bi-collection-fill fs-1 text-danger"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="card mt-4">

        <div class="card-body">

            <h4>
                Welcome 👋
            </h4>

            <p class="mb-0">

                Selamat datang di GameHub Database.

                Website ini dibuat untuk mempelajari relasi database:

            </p>

            <ul class="mt-3">

                <li>One-to-One</li>

                <li>One-to-Many</li>

                <li>Many-to-Many</li>

            </ul>

        </div>

    </div>

</div>

<?php

require_once 'includes/footer.php';

?>