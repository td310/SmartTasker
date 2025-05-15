<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'date',
            'password' => 'hashed',
        ];
    }

    public function avatar()
    {
        $email = md5($this->email);

        return "https://gravatar.com/avatar/{$email}?" . http_build_query([
            's' => 60,
            'd' => 'https://s3.amazonaws.com/laracasts/images/default-square-avatar.jpg'
        ]);

        // return Attribute::make(
        //     get: fn (string $value) => ucfirst($value),
        // );
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_user', 'user_id', 'project_id');
    }

    public function accessibleProjects()
    {
        return Project::where('user_id', $this->id)
            ->withCount('tasks')
            ->orWhereHas('members', function ($query) {
                $query->where('user_id', $this->id);
            })
            ->paginate(20);
    }
}