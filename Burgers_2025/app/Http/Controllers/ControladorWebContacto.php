<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Entidades\Cliente;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorWebContacto extends Controller
{
    public function index()
    {
            $sucursal = new Sucursal;
            $aSucursales = $sucursal->obtenerTodos();
            return view("web.contacto", compact("aSucursales"));
    }

    public function enviar(Request $request)
    {
            $Titulo = 'Contacto';
            $nombre = $request->input('txtNombre');
            $telefono = $request->input('txtTelefono');
            $correo = $request->input('txtCorreo');
            $comentario = $request->input('txtComentario');
            $sucursal = new Sucursal;
            $aSucursales = $sucursal->obtenerTodos();

            if ($correo !="" && $nombre !="" && $telefono !="" && $comentario !="") {

                $data = "Instrucciones";

                $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                try {
                    //Server settings
                    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = env('MAIL_HOST');  // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = env('MAIL_USERNAME');                 // SMTP username
                    $mail->Password = env('MAIL_PASSWORD');                           // SMTP password
                    $mail->SMTPSecure = env('MAIL_ENCRYPTION');                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = env('MAIL_PORT');                                    // TCP port to connect to

                    //Recipients
                    $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $mail->addAddress($correo);              // Name is optional
                

                    //Content
                    $mail->isHTML(true);
                    $mail->Subject = 'contacto';
                    $mail->Body    = "Los datos de acceso son:
                        Nombre: $nombre<br>
                        Telefono: $telefono<br>
                        Correo: $correo<br>
                        Comentario: $comentario<br>
                    ";

                    // $mail->send();
                    //  print_r($mail->Body);exit;
                     return view('web.contacto-gracias', compact('aSucursales'));
                } catch (Exception $e) {
                     $msg["ESTADO"] = MSG_ERROR;
                     $msg["MSG"] = "Hubo un error al enviar el correo.";
                    return view('web.contacto', compact('aSucursales', 'msg'));
                }
            } else {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
                return view('web.contacto', compact('aSucursales', 'msg'));
            }           
    }

    public function contactoGracias(Request $request){

    }

}
