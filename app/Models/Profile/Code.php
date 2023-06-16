<?php

namespace App\Models\Profile;

use App\Libraries\PageId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;

    protected $table = 'profile_codes';

    protected $fillable = [
        'profile_user_id',
        'profile_page_id',
        'code',
        'mode',
        'active',
        'used_at',
    ];

    //******** SCOPES *********//

    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeMinutesCreated($query, $minutes = 15)
    {
        return $query->where('created_at', '>=', now()->subMinutes($minutes)->toDateTimeString());
    }

    public function scopeByPageId($query, int $pageId)
    {
        return $query->where('profile_page_id', $pageId);
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    public function scopeByUserId($query, $userId)
    {
        return $query->where('profile_user_id', $userId);
    }

    //******** Queries *********//

    public function getLastActivationCode(int $userId)
    {
        return $this->active()->byPageId(PageId::ACTIVATION)->byUserId($userId)->latest()->first();
    }

    public function getLastChangePasswordCode(int $userId, bool $timeValidation = false)
    {
        if (! $timeValidation) {
            return $this->active()->ByPageId(PageId::CHANGED_PASSWORD)->byUserId($userId)->first();
        }

        return $this->active()->ByPageId(PageId::CHANGED_PASSWORD)->byUserId($userId)->minutesCreated(15)->first();
    }

    public function getLastForgotPasswordCode(int $userId)
    {
        return $this->active()->ByPageId(PageId::FORGOT_PASSWORD)->byUserId($userId)->minutesCreated(15)->first();
    }

    public function getByUserIdAndPageId(int $userId, int $pageId)
    {
        return $this->active()
            ->byPageId($pageId)
            ->byUserId($userId)
            ->first();
    }
}
