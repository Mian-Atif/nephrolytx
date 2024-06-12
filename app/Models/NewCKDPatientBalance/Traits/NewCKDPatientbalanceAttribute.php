<?php

namespace App\Models\NewCKDPatientBalance\Traits;

/**
 * Class NewCKDPatientbalanceAttribute.
 */
trait NewCKDPatientbalanceAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-newckdpatientbalance", "admin.newckdpatientbalances.edit")}
                {$this->getDeleteButtonAttribute("delete-newckdpatientbalance", "admin.newckdpatientbalances.destroy")}
                </div>';
    }
}
