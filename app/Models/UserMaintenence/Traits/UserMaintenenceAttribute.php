<?php

namespace App\Models\UserMaintenence\Traits;

/**
 * Class UserMaintenenceAttribute.
 */
trait UserMaintenenceAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-usermaintenence", "admin.usermaintenences.edit")}
                {$this->getDeleteButtonAttribute("delete-usermaintenence", "admin.usermaintenences.destroy")}
                </div>';
    }
}
