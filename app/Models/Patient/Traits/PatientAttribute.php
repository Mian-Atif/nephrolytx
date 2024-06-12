<?php

namespace App\Models\Patient\Traits;

/**
 * Class PatientAttribute.
 */
trait PatientAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-patient", "admin.patients.edit")}
                {$this->getDeleteButtonAttribute("delete-patient", "admin.patients.destroy")}
                </div>';
    }
}
