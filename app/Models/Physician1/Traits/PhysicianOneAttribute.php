<?php

namespace App\Models\Physician1\Traits;

/**
 * Class PhysicianOneAttribute.
 */
trait PhysicianOneAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-physicianone", "admin.physicianones.edit")}
                {$this->getDeleteButtonAttribute("delete-physicianone", "admin.physicianones.destroy")}
                </div>';
    }
}
