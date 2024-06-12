<?php

namespace App\Models\PracticeUser\Traits;

/**
 * Class PracticeuserAttribute.
 */
trait PracticeuserAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-practiceuser", "admin.practiceusers.edit")}
                {$this->getDeleteButtonAttribute("delete-practiceuser", "admin.practiceusers.destroy")}
                </div>';
    }
}
