<?php
session_start();
include 'conexion.php';

$usuario_id = 1; // Esto debería ser el ID del usuario actualmente logueado

// Obtener el carrito activo del usuario
$sql = "SELECT id FROM carritos WHERE usuario_id = $usuario_id AND estado = 'activo'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $carrito_id = $row['id'];

    // Obtener los productos en el carrito con sus detalles
    $sql = "SELECT productos.id, productos.nombre, productos.precio, productos.imagen_url, carrito_items.cantidad 
            FROM carrito_items 
            JOIN productos ON carrito_items.producto_id = productos.id 
            WHERE carrito_items.carrito_id = $carrito_id";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="../styles/style.css" rel="stylesheet">
    <link href="../styles/cart.css" rel="stylesheet">
    <title>Carrito</title>
</head>
<body>
    <header class="mb-auto">
        <div>
            <h3 class="float-md-start mb-0">Company</h3>
            <nav class="nav nav-masthead justify-content-center float-md-end">
                <a class="nav-link active" aria-current="page" href="../index.html">Home</a>
                <a class="nav-link" href="../assets/components/shopGallery.php">Shop</a>
                <a class="nav-link" href="carrito.php">Cart</a> <!-- Enlace al carrito -->
                <a class="nav-link" href="../assets/components/contact.php">Contact</a>
            </nav>
        </div>
    </header>
    <main class="page">
        <section class="shopping-cart dark">
            <div class="container">
                <div class="block-heading">
                    <h2>Cart</h2>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="col-md-12 col-lg-8">
                            <div class="items">
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<div class="product">';
                                        echo '<div class="row">';
                                        echo '<div class="col-md-3">';
                                        echo '<img class="img-fluid mx-auto d-block image" src="' . $row["imagen_url"] . '">';
                                        echo '</div>';
                                        echo '<div class="col-md-8">';
                                        echo '<div class="info">';
                                        echo '<div class="row">';
                                        echo '<div class="col-md-5 product-name">';
                                        echo '<div class="product-name">';
                                        echo '<a href="#">' . $row["nombre"] . '</a>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '<div class="col-md-4 quantity">';
                                        echo '<label for="quantity">Quantity:</label>';
                                        echo '<input id="quantity" type="number" value="' . $row["cantidad"] . '" class="form-control quantity-input">';
                                        echo '</div>';
                                        echo '<div class="col-md-3 price">';
                                        echo '<span>$' . $row["precio"] . '</span>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p>Tu carrito está vacío.</p>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="summary">
                                <h3>Summary</h3>
                                <div class="summary-item"><span class="text">Subtotal</span><span class="price">$360</span></div>
                                <div class="summary-item"><span class="text">Discount</span><span class="price">$0</span></div>
                                <div class="summary-item"><span class="text">Shipping</span><span class="price">$0</span></div>
                                <div class="summary-item"><span class="text">Total</span><span class="price">$360</span></div>
                                <button type="button" class="btn btn-danger btn-lg btn-block">Checkout</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
