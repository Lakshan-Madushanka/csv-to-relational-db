<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public const columns = [
        "series_reference",
        "period",
        "data_value",
        "suppress",
        "status",
        "unit",
        "magnitude",
        "subject",
        "group",
        "series_title",
    ];
}
