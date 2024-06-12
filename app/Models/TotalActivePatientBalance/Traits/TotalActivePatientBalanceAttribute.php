<?php

namespace App\Models\TotalActivePatientBalance\Traits;

/**
 * Class TotalActivePatientBalanceAttribute.
 */
trait TotalActivePatientBalanceAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-totalactivepatientbalance", "admin.totalactivepatientbalances.edit")}
                {$this->getDeleteButtonAttribute("delete-totalactivepatientbalance", "admin.totalactivepatientbalances.destroy")}
                </div>';
    }
}
