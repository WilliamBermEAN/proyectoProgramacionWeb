<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];
    $usuario_id = 1; // Esto debería ser el ID del usuario actualmente logueado

    // Verifica si el carrito ya existe para el usuario
    $sql = "SELECT id FROM carritos WHERE usuario_id = $usuario_id AND estado = 'activo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Si hay un carrito activo
        $row = $result->fetch_assoc();
        $carrito_id = $row['id'];
    } else {
        // Si no hay un carrito activo, crea uno nuevo
        $sql = "INSERT INTO carritos (usuario_id) VALUES ($usuario_id)";
        if ($conn->query($sql) === TRUE) {
            $carrito_id = $conn->insert_id;
        } else {
            die("Error al crear el carrito: " . $conn->error);
        }
    }

    // Añade el producto al carrito
    $sql = "INSERT INTO carrito_items (carrito_id, producto_id, cantidad) VALUES ($carrito_id, $producto_id, $cantidad)";
    if ($conn->query($sql) === TRUE) {
        echo "Producto añadido al carrito";
    } else {
        echo "Error al añadir el producto al carrito: " . $conn->error;
    }
}

$conn->close();

?>