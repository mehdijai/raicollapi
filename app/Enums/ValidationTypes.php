<?php

namespace App\Enums;

enum ValidationTypes: string
{
    case ADD_ARTIST = 'add_artist';
    case UPDATE_ARTIST = 'update_artist';
    case ADD_TRACK = 'add_track';
    case UPDATE_TRACK = 'update_track';
    case ADD_ALBUM = 'add_album';
    case UPDATE_ALBUM = 'update_album';
}
