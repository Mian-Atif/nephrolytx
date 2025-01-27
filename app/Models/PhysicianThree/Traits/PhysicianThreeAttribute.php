<?php

namespace App\Models\PhysicianThree\Traits;

/**
 * Class PhysicianThreeAttribute.
 */
trait PhysicianThreeAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-physicianthree", "admin.physicianthrees.edit")}
                {$this->getDeleteButtonAttribute("delete-physicianthree", "admin.physicianthrees.destroy")}
                </div>';
    }
}
