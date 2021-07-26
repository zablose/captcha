<?php

declare(strict_types=1);

namespace Zablose\Captcha\Exception;

use Exception;
use Zablose\Captcha\Config;

class CompressionIsOutOfRangeException extends Exception
{
    protected $message = 'Compression is out of range! '
    .'None '.Config::COMPRESSION_NONE.' and max '.Config::COMPRESSION_MAX.').';
}
