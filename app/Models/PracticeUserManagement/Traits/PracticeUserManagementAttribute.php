<?php

namespace App\Models\PracticeUserManagement\Traits;

/**
 * Class PracticeUserManagementAttribute.
 */
trait PracticeUserManagementAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-practiceusermanagement", "admin.practiceusermanagements.edit")}
                {$this->getDeleteButtonAttribute("delete-practiceusermanagement", "admin.practiceusermanagements.destroy")}
                </div>';
    }
}
