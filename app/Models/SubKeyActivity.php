<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKeyActivity extends Model
{
    use HasFactory;

    protected $table = 'key_sub_activities';

    protected $fillable = ['key_activity_id', 'sub_name', 'remarks'];

    public function activity()
    {
        return $this->belongsTo(KeyActivity::class);
    }
}
