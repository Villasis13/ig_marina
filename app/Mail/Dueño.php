<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Dueño extends Mailable
{
    use Queueable, SerializesModels;
    use SerializesModels;
    public $correo_corpo;
    public $mensaje_dueño;
    public $titulo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($correo_corporativo,$mensaje_dueño)
    {
        $this->correo_corpo = $correo_corporativo;
        $this->mensaje_dueño = $mensaje_dueño;
        $this->titulo = '¡Compra efectuado en la pagina web!';
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
        return $this
            ->from('soporte@emyspets.com', $this->correo_corpo)
            ->subject($this->titulo)
//            ->attach($this->modelo->archivo)
            ->view('emails.confirmacion_due_venta') ->with([
                'mensaje' => $this->mensaje_dueño,
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
            view: 'emails.confirmacion_due_venta',
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
