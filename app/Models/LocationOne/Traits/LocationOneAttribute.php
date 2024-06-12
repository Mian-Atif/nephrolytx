<?php

namespace App\Models\LocationOne\Traits;

/**
 * Class LocationOneAttribute.
 */
trait LocationOneAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-locationone", "admin.locationones.edit")}
                {$this->getDeleteButtonAttribute("delete-locationone", "admin.locationones.destroy")}
                </div>';
    }
}
