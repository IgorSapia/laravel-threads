<?php

namespace App\Exceptions;

use Exception;

class BusinessException extends Exception
{
    // Esta classe de excessão será usada para disparar exceptions relacionadas às regras de negocio.
    // Quando este tipo de excessão é lançada, retornamos a mensagem para o front, quando não, logamos e retornamos uma mensagem amigavel
}
