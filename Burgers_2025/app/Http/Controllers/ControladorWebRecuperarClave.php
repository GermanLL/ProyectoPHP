<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Session;


class ControladorWebRecuperarClave extends Controller
{
    public function index()
    {
            $sucursal = new Sucursal;
            $aSucursales = $sucursal->obtenerTodos();
            return view("web.recuperar_clave", compact("aSucursales"));
    }

    public function recuperar(Request $request){

         $sucursal = new Sucursal;
         $aSucursales = $sucursal->obtenerTodos();

        $titulo='Recupero de clave';
        $correo= $request->input('txtCorreo');
        $clave = rand(1000, 9999);

        $cliente = new Cliente();
        $cliente->obtenerPorCorreo($correo);
       

        if($cliente->correo !=""){
            //Envia  mail con las instrucciones

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
                $mail->addAddress($correo);               // Name is optional
              

                //Content
                $mail->isHTML(true);
                $mail->Subject = 'Recupero de clave';
                $mail->Body    = "Los datos de acceso son:
                Usuario: $cliente->correo
                Clave: $clave
                "; 

                //$mail->send();
                 $cliente->clave = password_hash($clave, PASSWORD_DEFAULT);
                 $cliente->guardar();
            
                $mensaje = "La nueva clave es $clave, y te la hemos enviado al correo.";
                //actualizar en el cliente la nueva ya encriptada
                return view('web.recuperar_clave', compact('titulo', 'mensaje','aSucursales'));

            } catch (Exception $e) {
                $mensaje = "Hubo un error al enviar el correo." .$e->getMessage();
                return view('web.recuperar_clave', compact('titulo', 'mensaje', 'aSucursales'));
            }  
        } else {
            $mensaje = "El email ingresado no existe";
            return view('web.recuperar_clave', compact('titulo', 'mensaje', 'aSucursales',));
        }
    }
}