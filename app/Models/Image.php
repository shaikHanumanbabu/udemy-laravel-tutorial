<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path'];

    public function imageble()
    {
        return $this->morphTo();
    }

    public function url()
    {
        return url('storage/'.$this->path);
    }
}
