<?php

// app/Models/ClubSection.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClubSection extends Model
{
    protected $fillable = [
        'title',
        'cta_text',
        'cta_link',
        'is_active',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(ClubItem::class);
    }
}
