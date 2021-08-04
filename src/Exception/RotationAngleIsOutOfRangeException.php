<?php

declare(strict_types=1);

namespace Zablose\Captcha\Exception;

use Exception;
use Zablose\Captcha\Config;

class RotationAngleIsOutOfRangeException extends Exception
{
    protected $message = 'Rotation angle is out of range! '
    .'No rotation "'.Config::ROTATION_ANGLE_NO_CHANGE.'" and max "'.Config::ROTATION_ANGLE_MAX.'".';
}
