<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Task extends Model
{
    protected $primaryKey = 'id_task';
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id_task)) {
                $model->id_task = (string) Str::uuid();
            }
        });
    }

    protected $fillable = [
        'id_user',
        'id_status',
        'title',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function masterStatus()
    {
        return $this->belongsTo(MasterStatus::class, 'id_status', 'id_status');
    }
}
