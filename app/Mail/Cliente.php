<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Cliente extends Mailable
{
    use Queueable, SerializesModels;
    use SerializesModels;
    public $persona;
    public $correo_corpo;
    public $docume;
    public $titulo;
    public $datos_venta;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($persona,$correo_corporativo,$archivo,$venta)
    {
        $this->persona = $persona;
        $this->correo_corpo = $correo_corporativo;
        $this->docume = $archivo;
        $this->datos_venta = $venta;
        $this->titulo = '¡Compra Exitosa!';
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->titulo,
        );
    }

    public function build()
    {
        $mensaje_cliente = "Agradecemos sinceramente su preferencia y confianza en nosotros. Estamos muy contentos por su compra y esperamos que disfrute de sus productos. ¡Gracias por elegirnos!";
        if (session('datos_usuario')){
            $validar_logueado = true;
        }else{
            $validar_logueado = false;
        }
        return $this
            ->from('soporte@emyspets.com', $this->correo_corpo)
            ->subject($this->titulo)
            ->attach($this->docume)
            ->view('emails.confirmacion_cliente_venta') ->with([
                'mensaje' => $mensaje_cliente,
                'persona' => $this->persona,
                'venta' => $this->datos_venta,
                'validar' => $validar_logueado,
                // Agrega más variables según sea necesario
            ]);
    }
    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.confirmacion_cliente_venta',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
