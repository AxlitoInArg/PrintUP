<?php

include "./libs/obtener_tipo_usuario.php";
session_start();
$type_user = obtenerTipoUsuario();
$id_usuario = $_SESSION['datos_usuario']['id_usuario'];

function obtener_pedido_cliente($id)
{
    require "./libs/conn.php";

    // Obtener pedidos del usuario
    $sql = "SELECT p.id, p.DNI_Usuario, p.descripcion, p.fecha_creacion, e.fecha_actualizacion, e.estado
        FROM pedidos p
        JOIN estado_pedido e ON p.id = e.pedido_id
        WHERE DNI_Usuario = '$id'";
    $result = mysqli_query($conn, $sql);

    // Verificar si la consulta tuvo éxito
    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conn));
    }
    return $result;
}

function obtener_todos_los_pedidos()
{
    require "./libs/conn.php";

    // Obtener todos los pedidos
    $sql = "SELECT p.id, p.DNI_Usuario, p.descripcion, p.fecha_creacion, e.fecha_actualizacion, e.estado
        FROM pedidos p
        JOIN estado_pedido e ON p.id = e.pedido_id;";
    $result = mysqli_query($conn, $sql);

    // Verificar si la consulta tuvo éxito
    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conn));
    }
    return $result;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/icono.png" type="image/x-icon">
    <title>Historial - PrintUP</title>
    <link rel="stylesheet" href="./assets/styles/all.min.css">
    <link rel="stylesheet" href="./assets/styles/normalize.css">
    <link rel="stylesheet" href="./assets/styles/global.css">
    <link rel="stylesheet" href="./assets/styles/noti.css">
    <style>
        /* Estilos adicionales para el modal */
        #modalFondo {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        #modal {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            max-width: 80%;
            overflow: auto;
            display: flex;
            flex-direction: column;
        }

        #modal button {
            background-color: #0084ff;
            border: none;
            color: white;
            padding: 10px 20px;
            margin: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        #modal button:hover {
            background-color: #005bb5;
        }
    </style>
</head>

<body>
    <div class="arriba">
        <div>
            <img src="./assets/img/logo_negro.png" alt="PrintUP Logo" class="logo">
        </div>
        <?php
        if ($type_user == "user_normal") {
            echo "Notificaciones clientes";
        } else {
            echo "Notificaciones kiosco";
        }
        ?>
    </div>
    <main>
        <?php
        $tipos_estados = ["1" => "Enviado", "2" => "Leido", "3" => "En Proceso", "4" => "Impresión finalizada", "5" => "Entregado"];

        if ($type_user == "user_kiosquero") {
            $result = obtener_todos_los_pedidos();
            // Mostrar pedidos
            if (mysqli_num_rows($result) > 0) {
                echo '<div class="notificaciones">';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="notificacion">';
                    echo '<h3>Pedido #' . $row['id'] . '</h3>';
                    echo '<p>' . $row['descripcion'] . '</p>';
                    echo '<p>Fecha de creación: ' . $row['fecha_creacion'] . '</p>';
                    echo '<p>Última Actualización: ' . $row['fecha_actualizacion'] . '</p>';
                    echo '<p>Estado: ' . $tipos_estados[$row['estado']] . '</p>';
                    echo "<div class='container_boton'><button class='boton_abrir_modal' data-id='" . $row['id'] . "'><i class='fa-solid fa-pen-to-square'></i></button></div>";
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<p class="nada_pedidos">No tienes pedidos.</p>';
            }
        } else {
            $result = obtener_pedido_cliente($id_usuario);
            // Mostrar pedidos
            if (mysqli_num_rows($result) > 0) {
                echo '<div class="notificaciones">';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="notificacion">';
                    echo '<h3>Pedido #' . $row['id'] . '</h3>';
                    echo '<p>' . $row['descripcion'] . '</p>';
                    echo '<p>Fecha de creación: ' . $row['fecha_creacion'] . '</p>';
                    echo '<p>Última Actualización: ' . $row['fecha_actualizacion'] . '</p>';
                    echo '<p>Estado: ' . $tipos_estados[$row['estado']] . '</p>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<p class="nada_pedidos">No tienes pedidos.</p>';
            }
        }



        ?>
    </main>
    <div id="modalFondo">
        <div id="modal">
            <?php
            $opciones = [1 => "¿Podrías imprimir estos archivos por favor? Adjunto. Gracias."];
            foreach ($tipos_estados as $key => $value) {
                echo "<button data-id='$key'>$value</button>";
                // <button data-id="2">Botón 2</button>
            }

            ?>
            <button id="cerrarModal">Cerrar</button>
        </div>
    </div>
    <script defer>
        const $modalFondo = document.getElementById('modalFondo');
        const $modal = document.getElementById('modal');
        const $botonAbrirModal = document.querySelectorAll('.boton_abrir_modal');
        const $botonCerrarModal = document.getElementById('cerrarModal');
        async function enviarMensaje(a, b) {
            const formData = new FormData();
            formData.append("pedido_id", a);
            formData.append("nuevo_estado", b);

            try {
                const res = await fetch("/api/actualizar_estado_pedido.php", {
                    method: "POST",
                    body: formData,
                });
                return await res.text();
            } catch (error) {
                console.error("Error al enviar el mensaje:", error);
                return undefined;
            }
        }

        $botonAbrirModal.forEach((elem) => {
            elem.addEventListener('click', () => {
                $modalFondo.style.display = 'flex';
                localStorage.estate = elem.getAttribute("data-id")
            });
        })


        $botonCerrarModal.addEventListener('click', () => {
            $modalFondo.style.display = 'none';

        });

        // Puedes manejar la acción de cada botón dentro del modal usando los data-id
        $modal.querySelectorAll('button[data-id]').forEach(button => {
            button.addEventListener('click', () => {
                const dataId = button.getAttribute('data-id');
                if (localStorage.estate !== 0) {
                    enviarMensaje(localStorage.estate, dataId);
                    localStorage.estate = 0;
                    location.reload()
                }

                $modalFondo.style.display = 'none'; // Cierra el modal después de seleccionar
            });
        });
    </script>
    <?php include "./componets/navbar.php" ?>
</body>

</html>