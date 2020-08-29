<?php
/*--------------------
https://github.com/jazmy/laravelformbuilder
Licensed under the GNU General Public License v3.0
Author: Jasmine Robinson (jazmy.com)
Last Updated: 12/29/2018
----------------------*/
namespace jazmy\FormBuilder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Form extends Model
{
    const FORM_PUBLIC = "PUBLIC";
    const FORM_PRIVATE = "PRIVATE";

    /**
     * The form visibility constants as an dropdown array
     *
     * @var array
     */
    public static $visibility_options = [
        ['id' => self::FORM_PUBLIC, 'name' => self::FORM_PUBLIC.' (available to all users)'],
        ['id' => self::FORM_PRIVATE, 'name' => self::FORM_PRIVATE.' (available to only logged in users)'],
    ];

    /**
     * The attributes that are not assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at', 'updated_at',
    ];

    /**
     * The attributes that should be casted to another data type
     *
     * @var array
     */
    protected $casts = [
        'allows_edit' => 'boolean',
    ];

    /**
     * A Form belongs to a User
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('formbuilder.models.user'));
    }

    /**
     * A Form has many Submission
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * Scope publicly visible forms
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopePublic($query)
    {
        return $query->where('visibility', self::FORM_PUBLIC);
    }

    /**
     * Get a json decoded version of the form_builder_json string
     *
     * @return array
     */
    public function getFormBuilderArrayAttribute($value) : array
    {
        return json_decode($this->attributes['form_builder_json'], true);
    }

    /**
     * Check if the form allows edit
     *
     * @return boolean
     */
    public function allowsEdit() : bool
    {
        return $this->allows_edit;
    }

    /**
     * Check if the form has public visibility
     *
     * @return boolean
     */
    public function isPublic() : bool
    {
        return $this->visibility === self::FORM_PUBLIC;
    }

    /**
     * Check if the form has private visibility
     *
     * @return boolean
     */
    public function isPrivate() : bool
    {
        return $this->visibility === self::FORM_PRIVATE;
    }

    /**
     * Check if the form has custom submit url
     *
     * @return boolean
     */
    public function hasCustomSubmitUrl() : bool
    {
        return ! empty($this->custom_submit_url);
    }

    /**
     * Get the forms that belong to the provided user
     *
     * @param User $user
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function getForUser($user)
    {
        return static::where('user_id', $user->id)
                    ->withCount('submissions')
                    ->latest()
                    ->paginate(100);
    }

    /**
     * Get an array containing the name of the fields in the form and their label
     *
     * @return Illuminate\Support\Collection
     */
    public function getEntriesHeader() : Collection
    {
        return collect($this->form_builder_array)
                    ->filter(function ($entry) {
                        return ! empty($entry['name']);
                    })
                    ->map(function ($entry) {
                        return [
                            'name' => $entry['name'],
                            'label' => $entry['label'] ?? null,
                            'type' => $entry['type'] ?? null,
                        ];
                    });
    }
}
