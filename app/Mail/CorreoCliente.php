<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorreoCliente extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;
    public $cliente;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($usuario, $cliente)
    {
        $this->usuario = $usuario;
        $this->cliente = $cliente;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@avicolaelmadrono.com')
                    ->view('correos.nuevocliente');
    }
}
