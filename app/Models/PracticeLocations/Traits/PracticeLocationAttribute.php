<?php

namespace App\Models\PracticeLocations\Traits;

/**
 * Class PracticeLocationAttribute.
 */
trait PracticeLocationAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-practicelocation", "admin.practicelocations.edit")}
                {$this->getDeleteButtonAttribute("delete-practicelocation", "admin.practicelocations.destroy")}
                </div>';
    }
}
