<?php

namespace App\Models\LatePatientBalance\Traits;

/**
 * Class LatePatientBalanceAttribute.
 */
trait LatePatientBalanceAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-latepatientbalance", "admin.latepatientbalances.edit")}
                {$this->getDeleteButtonAttribute("delete-latepatientbalance", "admin.latepatientbalances.destroy")}
                </div>';
    }
}
