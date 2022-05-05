<?php

namespace App\Http\Enums;

enum CustomerMetaCodeEnum: string
{
    // TODO: migrate data if smth changes
    case LANGUAGE = 'language';
    case HOMETOWN = 'hometown';
    case EYE_COLOR = 'eye_color';
}
