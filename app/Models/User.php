<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Channels\MailChannel;
use App\Channels\SmsChannel;
use App\Models\Profile\Code;
use App\Models\Profile\Country;
use App\Models\Profile\PasswordHistory;
use App\Models\Profile\Session;
use App\Models\Remittance\ProfileRemit;
use App\Models\Stripe\ProfileStripe;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'profile_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'profile_country_id',
        'api_merchant_id',
        'first_name',
        'middle_name',
        'first_last_name',
        'second_last_name',
        'email',
        'phone',
        'province_state',
        'province_state_iso',
        'city',
        'address',
        'zip_code',
        'birth_date',
        'gender',
        'password',
        'auth',
        'active',
        'locked',
        'disabled',
        'active_at',
        'locked_at',
        'disabled_at',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'profile_country_id',
        'api_merchant_id',
        'active',
        'password',
        'auth',
        'updated_at',
        'created_at',
        'locked_at',
        'disabled_at',
        'locked',
        'disabled',
        'active_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'disabled' => 'boolean',
        'locked' => 'boolean',
        'active' => 'boolean',
    ];

    protected function firstName(): Attribute
    {
        return Attribute::make(
            set: static fn($value) => ucfirst(strtolower($value)),
        );
    }

    protected function middleName(): Attribute
    {
        return Attribute::make(
            set: static fn($value) => $value === null ? null : ucfirst(strtolower($value)),
        );
    }

    public function firstLastName(): Attribute
    {
        return Attribute::make(
            set: static fn($value) => ucfirst(strtolower($value)),
        );
    }

    public function secondLastName(): Attribute
    {
        return Attribute::make(
            set: static fn($value) => $value === null ? null : ucfirst(strtolower($value)),
        );
    }

    public function email(): Attribute
    {
        return Attribute::make(
            set: static fn($value) => strtolower($value),
        );
    }

    public function password(): Attribute
    {
        return Attribute::make(
            set: static fn($value) => Hash::make($value),
        );
    }

    public function auth(): Attribute
    {
        return Attribute::make(
            get: static fn($value) => Crypt::decryptString($value),
            set: static fn($value) => Crypt::encryptString($value),
        );
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        // This application's users can receive notifications by mail and Twilio SMS
        return [MailChannel::class, SmsChannel::class];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /*_______________*/
    /* Relationships */
    /*_______________*/

    /**
     * Scope a query to only include users of a given type.
     *
     * @param int $type_code
     *
     * @return HasOne
     */
    public function getCode(int $type_code): HasOne
    {
        return $this->code()->where([
            ['active', 1],
            ['profile_page_id', $type_code],
        ]);
    }

    public function code(): HasOne
    {
        return $this->hasOne(Code::class, 'profile_user_id', 'id');
    }

    public function remittance(): HasOne
    {
        return $this->hasOne(ProfileRemit::class, 'profile_user_id', 'id');
    }

    public function passwordHistory(): HasMany
    {
        return $this->hasMany(PasswordHistory::class)->latest();
    }

    public function session(): HasOne
    {
        return $this->hasOne(Session::class, 'id', 'profile_user_id');
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class, 'id', 'profile_country_id');
    }

    public function stripeProfile(): HasOne
    {
        return $this->hasOne(ProfileStripe::class, 'profile_user_id', 'id');
    }

    /*________*/
    /* Queries */
    /*________*/

    public function deletePasswordHistory(): void
    {
        $keep = config('password-history.keep');
        $ids = $this->passwordHistory()
            ->pluck('id')
            ->sort()
            ->reverse();

        if ($ids->count() < $keep) {
            return;
        }

        $delete = $ids->splice($keep);

        $this->passwordHistory()
            ->whereIn('id', $delete)
            ->delete();
    }

    public function getFullNameShort(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
