<?php

namespace Exdeliver\Causeway\Domain\Entities\Event;

use Carbon\Carbon;
use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Rennokki\Befriended\Contracts\Likeable;
use Rennokki\Befriended\Traits\CanBeLiked;

/**
 * Class Comment
 * @package Domain\Entities\Comments
 */
class CalendarItem extends AggregateRoot implements Likeable, \MaddHatter\LaravelFullcalendar\Event
{
    use CanBeLiked;

    /**
     * @var string
     */
    protected $table = 'calendar_items';

    /**
     * @var array
     */
    protected $dates = ['start_datetime', 'end_datetime'];

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * Get all of the owning commentable models.
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get comment.
     *
     * @return string
     */
    public function getCommentAttribute()
    {
        return json_decode($this->data, false)->comment;
    }

    /**
     * Get the event's id number
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the event's title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Is it an all day event?
     *
     * @return bool
     */
    public function isAllDay()
    {
        return (bool)$this->all_day;
    }

    /**
     * Get the start time
     *
     * @return DateTime
     */
    public function getStart()
    {
        return Carbon::parse($this->start_datetime);
    }

    /**
     * Get the end time
     *
     * @return DateTime
     */
    public function getEnd()
    {
        return Carbon::parse($this->end_datetime);
    }

    /**
     * Set the label value.
     *
     * @param $value
     */
    public function setSlugAttribute($value): void
    {
        if (isset($value)) {
            if ($value !== $this->slug) {
                // Set slug
                $this->attributes['slug'] = $this->generateIteratedName('slug', $value);
            }
        } else {
            // Otherwise empty the slug
            $this->attributes['slug'] = null;
        }
    }

    public function getStartDatetimeAttribute()
    {
        return $this->attributes['start_datetime'];
    }
}