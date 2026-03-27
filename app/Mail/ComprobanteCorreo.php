<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComprobanteCorreo extends Mailable
{
    use Queueable, SerializesModels;
    use SerializesModels;

    private $correo_corporativo;
    private $comprobante;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($comprobante,$correo)
    {
        $this->correo_corporativo = $correo;
        $this->comprobante = $comprobante;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Comprobante de venta ',
        );
    }
    public function build()
    {
        $mensaje = "Agradecemos sinceramente su preferencia y confianza en nosotros. Estamos muy contentos por su compra y esperamos que disfrute de sus productos. ¡Gracias por elegirnos!";

        return $this
            ->from(env('MAIL_USERNAME'), $this->correo_corporativo)
            ->subject('Comprobante de venta')
            ->attach($this->comprobante)
            ->view('emails.ComprobanteCorreo') ->with([
                'mensaje' => $mensaje,
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
            view: 'emails.ComprobanteCorreo',
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
