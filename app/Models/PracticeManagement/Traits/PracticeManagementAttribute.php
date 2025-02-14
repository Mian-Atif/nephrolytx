<?php

namespace App\Models\PracticeManagement\Traits;

/**
 * Class PracticeManagementAttribute.
 */
trait PracticeManagementAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-practicemanagement", "admin.practicemanagements.edit")}
                {$this->getDeleteButtonAttribute("delete-practicemanagement", "admin.practicemanagements.destroy")}
                </div>';
    }
}
