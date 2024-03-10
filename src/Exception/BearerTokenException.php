<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;

final class BearerTokenException extends RuntimeException
{
    protected $message = 'Something happened. Could not retrieve the Bearer Token.';

}
