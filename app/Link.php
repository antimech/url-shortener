<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash', 'link',
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'hash';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['short_link'];

    /**
     * Get the short link.
     *
     * @return string
     */
    public function getShortLinkAttribute()
    {
        return route('link.show', $this->hash);
    }
}
