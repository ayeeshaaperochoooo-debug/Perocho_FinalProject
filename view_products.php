
<?php
require 'db_connect.php';

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$search = trim($_GET['search'] ?? '');

if ($search !== '') {
    $stmt = $pdo->prepare("
        SELECT * FROM products
        WHERE name LIKE ? OR category LIKE ? OR brand LIKE ?
        ORDER BY id DESC
    ");
    $term = "%$search%";
    $stmt->execute([$term, $term, $term]);
} else {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Products</title>

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

        /* PAGE TITLE */
        .page-title {
            color: #51427D;
            font-weight: bold;
        }

        /* CONTENT CARD */
        .content-card {
            background: #FFFFFF;
            border: 1px solid #E7E0F2;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(117,96,165,0.06);
        }

        .content-card h4 {
            color: #9275D8;
            font-weight: bold;
        }

        /* SEARCH INPUT */
        .form-control {
            background: #FAF9FE;
            border: 1px solid #DDD5ED;
            color: #51427D;
            padding: 11px;
            border-radius: 9px;
        }

        .form-control:focus {
            background: #FFFFFF;
            color: #51427D;
            border-color: #9275D8;
            box-shadow: 0 0 0 0.2rem rgba(169,145,232,0.2);
        }

        .form-control::placeholder {
            color: #A49CB5;
        }

        /* TABLE */
        .table {
            vertical-align: middle;
            color: #51427D;
        }

        .table thead th {
            background: #E9E2FA;
            color: #51427D;
            padding: 15px;
            white-space: nowrap;
        }

        .table tbody td {
            background: #FFFFFF;
            color: #51427D;
            padding: 13px 15px;
        }

        .table-hover tbody tr:hover td {
            background: #F2EEFC;
            color: #51427D;
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

        .btn-warning {
            background: #FFE09A;
            border: none;
            color: #69501D;
        }

        .btn-warning:hover {
            background: #F5CC72;
            color: #594014;
        }

        .btn-danger {
            background: #F2A5B8;
            border: none;
            color: #78384B;
        }

        .btn-danger:hover {
            background: #E889A2;
            color: white;
        }

        /* ALERT */
        .alert-success {
            background: #DDF5E9;
            border: 1px solid #B8E6D0;
            color: #35765B;
            border-radius: 10px;
        }

        /* FOOTER */
        footer {
            color: #938AA6;
            text-align: center;
            padding: 25px;
            margin-top: 40px;
        }

        @media(max-width: 768px) {
            .content-card {
                padding: 15px;
            }

            .table {
                font-size: 13px;
            }

            .page-title {
                font-size: 23px;
            }
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="bi bi-shop"></i> ElectroStore
        </a>

        <button class="navbar-toggler bg-light" type="button"
            data-bs-toggle="collapse" data-bs-target="#menu">
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

<!-- MAIN CONTENT -->
<div class="container">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h2 class="page-title mb-1">
                <i class="bi bi-box-seam"></i> Product Inventory
            </h2>
            <p class="text-secondary mb-0">
                Manage and monitor your electronic store products.
            </p>
        </div>
    </div>

    <!-- SUCCESS MESSAGES -->
    <?php if (($_GET['success'] ?? '') === 'added'): ?>
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i>
            Product added successfully!
        </div>
    <?php elseif (($_GET['success'] ?? '') === 'updated'): ?>
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i>
            Product updated successfully!
        </div>
    <?php elseif (($_GET['success'] ?? '') === 'deleted'): ?>
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i>
            Product deleted successfully!
        </div>
    <?php endif; ?>

    <!-- SEARCH SECTION -->
    <div class="content-card">
        <h4 class="mb-3">
            <i class="bi bi-search"></i> Search Products
        </h4>

        <form method="GET" class="row g-2">
            <div class="col-md-9">
                <input
                    type="search"
                    name="search"
                    class="form-control"
                    placeholder="Search product name, category, or brand..."
                    value="<?= e($search) ?>">
            </div>

            <div class="col-md-3 d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Search Product
                </button>
            </div>
        </form>
    </div>

    <!-- PRODUCT TABLE -->
    <div class="content-card">

        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h4 class="mb-0">
                <i class="bi bi-list-ul"></i> Products List
            </h4>

            <span style="color:#9275D8;">
                Total: <?= count($products) ?> products
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Warranty</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                <?php if ($products): ?>

                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= e($product['id']) ?></td>
                            <td><strong><?= e($product['name']) ?></strong></td>
                            <td><?= e($product['category']) ?></td>
                            <td><?= e($product['brand']) ?></td>
                            <td>₱<?= number_format((float)$product['price'], 2) ?></td>
                            <td><?= e($product['quantity']) ?></td>
                            <td><?= e($product['warranty']) ?></td>

                            <td class="text-nowrap">
                                <a href="edit_product.php?id=<?= e($product['id']) ?>"
                                   class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>

                                <form action="delete_product.php" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this product?')">

                                    <input type="hidden" name="id"
                                        value="<?= e($product['id']) ?>">

                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="bi bi-inbox" style="font-size:35px;color:#9275D8;"></i>
                            <p class="mt-2 mb-0">No products found.</p>
                        </td>
                    </tr>

                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- FOOTER -->
<footer>
    <i class="bi bi-shop"></i>
    © 2026 ElectroStore | Product Management System
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
