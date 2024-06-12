<?php

namespace App\Models\ActivePatientBalance\Traits;

/**
 * Class ActivePatientBalanceAttribute.
 */
trait ActivePatientBalanceAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-activepatientbalance", "admin.activepatientbalances.edit")}
                {$this->getDeleteButtonAttribute("delete-activepatientbalance", "admin.activepatientbalances.destroy")}
                </div>';
    }
}
