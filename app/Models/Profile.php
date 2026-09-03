<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'social'          => 'array',
        'is_downloadable' => 'boolean',
        'is_open_to_work' => 'boolean',
    ];

    /**
     * Defines a relationship where the profile belongs to a user.
     *
     * @return BelongsTo The relationship instance linking the profile to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the resolved and formatted Calendly URL from direct field or social links.
     */
    public function getResolvedCalendlyUrlAttribute(): ?string
    {
        $url = null;

        if (! empty($this->calendly_url)) {
            $url = $this->calendly_url;
        } elseif (! empty($this->social) && is_array($this->social)) {
            foreach ($this->social as $item) {
                if (
                    ($item['is_active'] ?? false) &&
                    strtolower($item['social_network'] ?? '') === 'calendly' &&
                    ! empty($item['profile_link'])
                ) {
                    $url = $item['profile_link'];
                    break;
                }
            }
        }

        if (empty($url)) {
            return null;
        }

        return preg_match('~^https?://~i', $url) ? $url : 'https://' . $url;
    }
}

