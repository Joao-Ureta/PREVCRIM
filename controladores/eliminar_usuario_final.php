<?php
include '../config/config.php';

if (isset($_POST['rut'])) {
    $rut = $_POST['rut'];
    $sql = "DELETE FROM usuarios WHERE rut = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $rut);

    if ($stmt->execute()) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
          Swal.fire({
            icon: 'success',
            title: 'Usuario eliminado correctamente',
            showConfirmButton: false,
            timer: 2000
          }).then(() => {
            window.location.href = '../vistas/instituciones/carabineros/eliminar_usuario.php';
          });
        </script>";
    } else {
        echo "<script>
          Swal.fire('Error', 'No se pudo eliminar el usuario', 'error');
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
