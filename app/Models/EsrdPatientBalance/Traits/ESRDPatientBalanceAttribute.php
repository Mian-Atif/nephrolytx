<?php

namespace App\Models\EsrdPatientBalance\Traits;

/**
 * Class ESRDPatientBalanceAttribute.
 */
trait ESRDPatientBalanceAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-esrdpatientbalance", "admin.esrdpatientbalances.edit")}
                {$this->getDeleteButtonAttribute("delete-esrdpatientbalance", "admin.esrdpatientbalances.destroy")}
                </div>';
    }
}
