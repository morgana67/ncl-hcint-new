<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Traits\Translatable;

class Page extends Model
{
    use Translatable;
    protected $translatable = ['title', 'slug', 'body'];

    /**
     * Statuses.
     */
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INACTIVE = 'INACTIVE';

    public const PAGE_TYPE_STATIC = 'STATIC';
    public const PAGE_TYPE_DYNAMIC = 'DYNAMIC';

    /**
     * List of statuses.
     *
     * @var array
     */
    public static $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    protected $guarded = [];

    public function save(array $options = [])
    {
        // If no author has been assigned, assign the current user's id as the author of the post
        if (!$this->author_id && Auth::user()) {
            $this->author_id = Auth::user()->getKey();
        }
        if (strpos($this->slug, 'page/') === false) {
            $this->slug = 'page/'.$this->slug;
        }

        return parent::save();
    }

    /**
     * Scope a query to only include active pages.
     *
     * @param  $query  \Illuminate\Database\Eloquent\Builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', static::STATUS_ACTIVE);
    }

    public function scopePageDefault($query){
        return $query->whereNull('code_page');
    }

    public function scopePageStatic($query){
        return $query->whereNotNull('code_page');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('pageDefault', function (Builder $builder) {
            $builder->whereNull('code_page');
        });
    }


}
