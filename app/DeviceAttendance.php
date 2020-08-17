<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceAttendance extends Model
{
    protected $fillable = [
        'uuid', 'employee_id', 'award_category_id', 'gift_item', 'select_month', 'description', 'publication_status', 'deletion_status',

    ];
}
