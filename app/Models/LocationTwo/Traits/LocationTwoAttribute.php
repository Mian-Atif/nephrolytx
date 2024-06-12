<?php

namespace App\Models\LocationTwo\Traits;

/**
 * Class LocationTwoAttribute.
 */
trait LocationTwoAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-locationtwo", "admin.locationtwos.edit")}
                {$this->getDeleteButtonAttribute("delete-locationtwo", "admin.locationtwos.destroy")}
                </div>';
    }
}
