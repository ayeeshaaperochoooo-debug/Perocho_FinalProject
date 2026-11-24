
<?php
require 'db_connect.php';

$total = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$stock = $pdo->query("SELECT COALESCE(SUM(quantity),0) FROM products")->fetchColumn();
$value = $pdo->query("SELECT COALESCE(SUM(price * quantity),0) FROM products")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Store Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            background: #DCEBFF;
            color: #51427D;
        }

        /* NAVBAR */
        .navbar {
            background: #E9E2FA;
            border-bottom: 3px solid #C5B4F3;
            padding: 16px 0;
        }

        .navbar-brand {
            color: #51427D !important;
            font-size: 23px;
            font-weight: bold;
        }

        .nav-link {
            color: #655A83 !important;
        }

        .nav-link:hover {
            color: #9275D8 !important;
        }

        /* WELCOME BANNER */
        .welcome-banner {
            background: linear-gradient(120deg, #E9E2FA, #DCEBFF, #FFDDE8);
            padding: 35px;
            border-radius: 18px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .welcome-banner h2 {
            font-weight: bold;
            color: #51427D;
        }

        .welcome-banner p {
            color: #655A83;
        }

        .welcome-banner i {
            font-size: 75px;
            color: #9275D8;
        }

        /* DASHBOARD CARDS */
        .stat-card {
            background: #FFFFFF;
            border: 1px solid #9275D8;
            border-radius: 15px;
            padding: 23px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(117,96,165,0.07);
            transition: 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 18px rgba(117,96,165,0.13);
        }

        .stat-icon {
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            font-size: 25px;
            margin-bottom: 15px;
        }

        .purple {
            background: #F0E9FF;
            color: #9275D8;
        }

        .blue {
            background: #E3EEFF;
            color: #6396D9;
        }

        .pink {
            background: #FFE6EE;
            color: #E58AA8;
        }

        .stat-card p {
            color: #938AA6;
            margin-bottom: 5px;
        }

        .stat-card h2 {
            color: #51427D;
            font-weight: bold;
            font-size: 28px;
        }

        /* MANAGEMENT SECTION */
        .content-card {
            background: #FFFFFF;
            border: 1px solid #E7E0F2;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(117,96,165,0.06);
        }

        .content-card h4 {
            color: #9275D8;
            font-weight: bold;
        }

        .content-card p {
            color: #9275D8;
        }

        /* BUTTONS */
        .btn-primary {
            background: #A991E8;
            border: none;
            color: white;
            padding: 11px 22px;
            border-radius: 9px;
        }

        .btn-primary:hover {
            background: #9074D1;
            color: white;
        }

        .btn-secondary {
            background: #AABBD8;
            border: none;
            color: #34324A;
            padding: 11px 22px;
            border-radius: 9px;
        }

        .btn-secondary:hover {
            background: #91A6C8;
            color: white;
        }

        /* FOOTER */
        footer {
            color: #938AA6;
            text-align: center;
            padding: 25px;
            margin-top: 40px;
        }

        @media(max-width: 768px) {
            .welcome-banner {
                padding: 25px;
            }

            .welcome-banner h2 {
                font-size: 23px;
            }

            .stat-card {
                padding: 18px;
            }

            .content-card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="bi bi-shop"></i> WELCOME!!
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <i class="bi bi-grid"></i> Dashboard
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- DASHBOARD -->
<div class="container">

    <!-- WELCOME BANNER -->
    <div class="welcome-banner">
        <div>
            <h2>Welcome to ElectroStore!</h2>
            <p class="mb-3">
                Manage your electronic store products and inventory
                easily in one place.
            </p>
        </div>

        <div class="d-none d-md-block">
            <i class="bi bi-laptop"></i>
        </div>
    </div>

    <!-- PAGE TITLE -->
    <h2 class="page-title">Store Dashboard</h2>
    <p class="text-secondary mb-4">
        Here's an overview of your electronic store inventory.
    </p>

    <!-- STATISTICS -->
    <div class="row">

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="bi bi-box-seam"></i>
                </div>
                <p>Total Products</p>
                <h2><?= number_format($total) ?></h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-boxes"></i>
                </div>
                <p>Total Stock</p>
                <h2><?= number_format($stock) ?></h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon pink">
                    <i class="bi bi-wallet2"></i>
                </div>
                <p>Total Inventory Value</p>
                <h2>₱<?= number_format((float)$value, 2) ?></h2>
            </div>
        </div>

    </div>

    <!-- PRODUCT MANAGEMENT -->
    <div class="content-card text-center">
        <div class="mb-3">
            <i class="bi bi-grid-fill" style="font-size:35px;color:#9275D8;"></i>
        </div>

        <h4>Product Management</h4>
        <p>Choose an action to manage your electronic store inventory.</p>

        <a href="add_product.php" class="btn btn-primary m-2">
            <i class="bi bi-plus-circle"></i> Add Product
        </a>

        <a href="view_products.php" class="btn btn-secondary m-2">
            <i class="bi bi-clipboard-data"></i> View Products
        </a>
    </div>

</div>

<!-- FOOTER -->
<footer>
    <i class="bi bi-shop"></i>
    ElectroStore | Product Management System
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
