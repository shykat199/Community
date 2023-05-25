<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Community\Group\CommunityUserGroup;
use App\Models\Community\Group\CommunityUserGroupPost;
use App\Models\Community\Group\CommunityUserGroupPostComment;
use App\Models\Community\Page\CommunityPage;
use App\Models\Community\Page\CommunityPagePost;
use App\Models\Community\Page\CommunityPagePostComment;
use App\Models\Community\Page\UsersPage;
use App\Models\Community\User\CommunityUserDetails;
use App\Models\Community\User\CommunityUserFollowing;
use App\Models\Community\User_Post\CommunityUserPostComment;
use App\Models\Community\User_Profile\CommunityUserProfileCover;
use App\Models\Community\User_Profile\CommunityUserProfileLanguage;
use App\Models\Community\User_Profile\CommunityUserProfilePhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'email_verified_at',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pages(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(CommunityPage::class, 'users_pages', 'user_id', 'page_id');
    }

    public function languages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityUserProfileLanguage::class);
    }


    public function groups(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityUserGroup::class);
    }

    public function userProfileImages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityUserProfilePhoto::class,'user_id')->latest();
    }
    public function userCoverImages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityUserProfileCover::class,'user_id')->latest();
    }

    public function groupPosts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityUserGroupPost::class, 'user_id');
    }
    public function pagePosts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityPagePost::class, 'user_id');
    }

    public  function  communityUserPost(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityUserGroupPost::class,'user_id');
    }

    public function userComments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityUserPostComment::class,'user_id');
    }

    public function userGroupPostComments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityUserGroupPostComment::class,'user_id');
    }
    public function userPagePostComments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityPagePostComment::class,'user_id');
    }

    public function usersFollowers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityUserFollowing::class,'user_id');
    }

    public function userDetails(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(CommunityUserDetails::class);
    }


}
