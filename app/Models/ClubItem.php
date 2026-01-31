<?php

// app/Models/ClubItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClubItem extends Model
{
    protected $fillable = [
        'club_section_id',
        'image',
        'title',
        'duration',
        'place',
        'description',
        'order',
        'is_active',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(ClubSection::class, 'club_section_id');
    }
}
