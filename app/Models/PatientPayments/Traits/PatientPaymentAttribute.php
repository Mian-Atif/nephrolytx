<?php

namespace App\Models\PatientPayments\Traits;

/**
 * Class PatientPaymentAttribute.
 */
trait PatientPaymentAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-patientpayment", "admin.patientpayments.edit")}
                {$this->getDeleteButtonAttribute("delete-patientpayment", "admin.patientpayments.destroy")}
                </div>';
    }
}
