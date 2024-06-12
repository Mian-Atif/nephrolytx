<?php

namespace App\Models\Prayer\Traits;

/**
 * Class PrayerAttribute.
 */
trait PrayerAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-prayer", "admin.prayers.edit")}
                {$this->getDeleteButtonAttribute("delete-prayer", "admin.prayers.destroy")}
                </div>';
    }
}
