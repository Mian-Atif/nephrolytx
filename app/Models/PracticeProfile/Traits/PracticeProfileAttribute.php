<?php

namespace App\Models\PracticeProfile\Traits;

/**
 * Class PracticeProfileAttribute.
 */
trait PracticeProfileAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-practiceprofile", "admin.practiceprofiles.edit")}
                {$this->getDeleteButtonAttribute("delete-practiceprofile", "admin.practiceprofiles.destroy")}
                </div>';
    }
}
