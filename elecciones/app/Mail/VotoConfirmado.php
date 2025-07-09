<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VotoConfirmado extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Datos para el correo
     */
    public $candidatura;
    public $eleccion;
    public $fecha;

    /**
     * Create a new message instance.
     */
    public function __construct($candidatura, $eleccion, $fecha)
    {
        $this->candidatura = $candidatura;
        $this->eleccion = $eleccion;
        $this->fecha = $fecha;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Voto Confirmado',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.voto_confirmado',
            with: [
                'candidatura' => $this->candidatura,
                'eleccion' => $this->eleccion,
                'fecha' => $this->fecha,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
