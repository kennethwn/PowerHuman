<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_id'
    ];

    public function companies(): BelongsTo {
        return $this->belongsTo(Company::class);
    }

    public function users(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
