<?php
// Cargar el autoload de Composer para PHPMailer
require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Ctrl_Usuario
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function guardarUsuarioYEnviarCorreo($nombre, $email, $telefono, $plan)
    {
        // Guardar usuario en la base de datos
        $resultadoGuardado = $this->guardar($nombre, $email, $telefono, $plan);
    
        if ($resultadoGuardado === true) {
            // Enviar correo de confirmación
            $correoEnviado = $this->enviarCorreo($email, $nombre, $plan);
    
            if ($correoEnviado) {
                // Redirigir a la página de éxito si todo fue exitoso
                header("Location: exito.html");
                exit();  // Asegúrate de detener la ejecución del script después de la redirección
            } else {
                // En caso de que no se pueda enviar el correo, redirigir a registro con mensaje de error
                header("Location: registro.html?error=correo_no_enviado");
                exit();
            }
        } else {
            // Enviar mensaje de error a registro.html
            // Si hay un error en el registro
header('Location: /htmlgym/pages/membrecia/registro.php?error=correo_no_enviado');
exit();
        }
    }
    

    private function guardar($nombre, $email, $telefono, $plan)
    {
        try {
            // Verificar si el correo ya está registrado
            $sql = "SELECT * FROM membresias WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "El correo electrónico ya está registrado.";  // Mensaje de error si ya existe
            }

            // Si el correo no está registrado, insertar el nuevo usuario
            $sql = "INSERT INTO membresias (nombre, email, telefono, plan) VALUES (:nombre, :email, :telefono, :plan)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':plan', $plan);

            if ($stmt->execute()) {
                return true;  // Si la inserción fue exitosa
            } else {
                return "Error al guardar el usuario.";  // Error si la inserción falla
            }
        } catch (Exception $e) {
            error_log("Error al guardar el usuario: " . $e->getMessage());
            return "Error al guardar el usuario: " . $e->getMessage();
        }
    }

    private function enviarCorreo($destinatario, $nombre, $plan)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'soportet508@gmail.com';  // Tu correo de Gmail
            $mail->Password = 'jkcsvsuteipxznts';  // Contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;  // Puerto para TLS

            // Configuración del correo
            $mail->setFrom('soportet508@gmail.com', 'Gym Plataforma');
            $mail->addAddress($destinatario, $nombre);
            $mail->isHTML(true);
            $mail->Subject = 'Confirmación de Registro de Membresía';
            $mail->Body = "
                <html>
                <head>
                    <title>Confirmación de Registro</title>
                </head>
                <body>
                    <h2>Hola, $nombre</h2>
                    <p>Gracias por registrarte en Gym Plataforma. Hemos recibido tu solicitud para el plan <strong>$plan</strong>.</p>
                    <p>Si tienes alguna consulta, no dudes en contactarnos.</p>
                    <p>Atentamente, <br>El equipo de Gym Plataforma</p>
                </body>
                </html>
            ";

            // Enviar el correo
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Error al enviar el correo: {$mail->ErrorInfo}");
            return false;
        }
    }
}
?>
