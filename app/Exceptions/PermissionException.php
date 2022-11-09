<?php

namespace App\Exceptions;

use Exception;

class PermissionException extends Exception
{
    public function render(){ // Eccezione generata
        return response()->json(['errore' => 'Permessi insufficienti'], 403); // Errore HTTP 403 Accesso non autorizzato
    }
}
