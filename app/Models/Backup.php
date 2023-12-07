<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

class Backup extends Model
{
    use HasFactory;

    protected $table = 'backup_server_backups';

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    protected function sizeInKb(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Number::fileSize($value) : '',
        );
    }

    protected function realSizeInKb(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Number::fileSize($value) : '',
        );
    }
}
