<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\CorreoCliente;
use Mail;

class CorreoClienteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $usuario;
    protected $cliente;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($usuario, $cliente)
    {
        $this->usuario = $usuario;
        $this->cliente = $cliente;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $correo = new CorreoCliente($this->usuario, $this->cliente);
        Mail::to($this->usuario->correo_jefe)->send($correo);
    }
}
