<?php

namespace App\Models\ESRDPatientName\Traits;

/**
 * Class ESRDPatientAttribute.
 */
trait ESRDPatientAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-esrdpatient", "admin.esrdpatients.edit")}
                {$this->getDeleteButtonAttribute("delete-esrdpatient", "admin.esrdpatients.destroy")}
                </div>';
    }
}
