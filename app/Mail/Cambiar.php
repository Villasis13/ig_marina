<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Cambiar extends Mailable
{
    use Queueable, SerializesModels;
    use SerializesModels;
    public $titulo;
    public $mensaje;
    public $persona;
    public $logo;
    public $corporativo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($titulo,$mensaje,$persona,$logo,$corpo)
    {
        $this->titulo = $titulo;
        $this->mensaje = $mensaje;
        $this->persona = $persona;
        $this->logo = $logo;
        $this->corporativo = $corpo;
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
            ->from('soporte@emyspets.com', $this->corporativo)
            ->subject($this->titulo)
//            ->attach($this->modelo->archivo)
            ->view('emails.estado_venta_web') ->with([
                'mensaje' => $this->mensaje,
                'persona' => $this->persona,
                'logo' => $this->logo,
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
            view: 'emails.estado_venta_web',
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
