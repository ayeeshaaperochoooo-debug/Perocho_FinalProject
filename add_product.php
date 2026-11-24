
<?php
require 'db_connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $brand = trim($_POST['brand'] ?? '');
    $price = filter_var($_POST['price'] ?? '', FILTER_VALIDATE_FLOAT);
    $quantity = filter_var($_POST['quantity'] ?? '', FILTER_VALIDATE_INT);
    $warranty = trim($_POST['warranty'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($name === '' || $category === '' || $brand === '' ||
        $price === false || $price < 0 ||
        $quantity === false || $quantity < 0) {
        $error = "Please enter valid product information.";
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO products
            (name, category, brand, price, quantity, warranty, description)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $name, $category, $brand, $price,
            $quantity, $warranty, $description
        ]);

        header("Location: view_products.php?success=added");
        exit;
    }
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Product | ElectroStore</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            background: #DCEBFF;
            color: #51427D;
        }

        .navbar {
            background: #E9E2FA;
            border-bottom: 2px solid #C5B4F3;
            padding: 15px 0;
        }

        .navbar-brand {
            color: #51427D !important;
            font-weight: bold;
            font-size: 23px;
        }

        .nav-link {
            color: #655A83 !important;
            font-weight: 500;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #9275D8 !important;
        }

        .navbar-toggler {
            border-color: #C5B4F3;
        }

        .content-card {
            background: #fff;
            border: 1px solid #E7E0F2;
            border-radius: 18px;
            padding: 30px;
            margin: 45px auto;
            max-width: 850px;
            box-shadow: 0 5px 18px rgba(81, 66, 125, 0.08);
        }

        .page-title {
            color: #51427D;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .page-subtitle {
            color: #938AA6;
            margin-bottom: 28px;
        }

        .form-label {
            color: #51427D;
            font-weight: 600;
        }

        .form-control,
        .form-select {
            background: #FAF9FE;
            border: 1px solid #DDD5ED;
            border-radius: 9px;
            color: #51427D;
            padding: 11px 13px;
        }

        .form-control:focus,
        .form-select:focus {
            background:  #51427D;
            border-color: #A991E8;
            box-shadow: 0 0 0 0.2rem rgba(169, 145, 232, 0.2);
        }

        .btn-primary {
            background: #A991E8;
            border-color: #A991E8;
            color: #fff;
            border-radius: 9px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: #9074D1;
            border-color: #9074D1;
        }

        .btn-secondary {
            background: #AABBD8;
            border-color: #AABBD8;
            color: #fff;
            border-radius: 9px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .btn-secondary:hover {
            background: #91A6C8;
            border-color: #91A6C8;
            color: #fff;
        }

        .alert-danger {
            border: none;
            border-radius: 10px;
        }

        footer {
            text-align: center;
            color: #938AA6;
            padding: 20px;
            margin-top: 30px;
        }

        @media (max-width: 576px) {
            .content-card {
                padding: 20px;
                margin: 25px 12px;
            }
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">

        <a class="navbar-brand" href="index.php">
            <i class="bi bi-shop me-2"></i>ElectroStore
        </a>

        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <i class="bi bi-speedometer2 me-1"></i>Dashboard
                    </a>
                </li>
            </ul>
        </div>

    </div>
</nav>

<div class="container">
    <div class="content-card">

        <h3 class="page-title">
            <i class="bi bi-plus-circle me-2"></i>Add New Product
        </h3>

        <p class="page-subtitle">
            Enter the details below to add a new product to your inventory.
        </p>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle me-2"></i>
                <?= e($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control"
                        placeholder="Enter product name" required
                        value="<?= e($_POST['name'] ?? '') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select" required>
                        <option value="">Select Category</option>

                        <?php foreach (['Laptop','Smartphone','Television','Computer Accessories','Audio Devices','Other'] as $cat): ?>
                            <option value="<?= e($cat) ?>"
                                <?= ($_POST['category'] ?? '') === $cat ? 'selected' : '' ?>>
                                <?= e($cat) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Brand</label>
                    <input type="text" name="brand" class="form-control"
                        placeholder="Enter brand" required
                        value="<?= e($_POST['brand'] ?? '') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Price (₱)</label>
                    <input type="number" name="price" class="form-control"
                        min="0" step="0.01" placeholder="Enter price" required
                        value="<?= e($_POST['price'] ?? '') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity" class="form-control"
                        min="0" placeholder="Enter quantity" required
                        value="<?= e($_POST['quantity'] ?? '') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Warranty</label>
                    <input type="text" name="warranty" class="form-control"
                        placeholder="e.g. 1 Year"
                        value="<?= e($_POST['warranty'] ?? '') ?>">
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control"
                        rows="4" placeholder="Enter product description"><?= e($_POST['description'] ?? '') ?></textarea>
                </div>

            </div>

            <div class="d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Save Product
                </button>

                <a href="index.php" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </a>
            </div>

        </form>
    </div>
</div>

<footer>
    © 2026 ElectroStore | Product Management System
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
