<?php
// Iniciar la sesión
session_start();

// Crear un objeto con productos
$_SESSION['cart'] = [
    [
        'nombre' => 'Padre Rico Padre Pobre',
        'precio' => 120000,
        'cantidad' => 2
    ],
    [
        'nombre' => 'Si lo crees lo creas',
        'precio' => 70000,
        'cantidad' => 1
    ],
    [
        'nombre' => 'El hombre mas rico de babilonía',
        'precio' => 200000,
        'cantidad' => 3
    ]
];


// Verificar el contenido de la sesión
echo '<pre>';
print_r($_SESSION['cart']);
echo '</pre>';
?>