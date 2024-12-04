<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyActivity extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'pic'];

    public function subActivities()
    {
        return $this->hasMany(SubKeyActivity::class);
    }

    public function dateRanges()
    {
        return $this->hasMany(DateRange::class, 'key_activity_id');
    }
}
