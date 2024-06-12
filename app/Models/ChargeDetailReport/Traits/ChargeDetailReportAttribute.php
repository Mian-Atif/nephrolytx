<?php

namespace App\Models\ChargeDetailReport\Traits;

/**
 * Class ChargeDetailReportAttribute.
 */
trait ChargeDetailReportAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-chargedetailreport", "admin.chargedetailreports.edit")}
                {$this->getDeleteButtonAttribute("delete-chargedetailreport", "admin.chargedetailreports.destroy")}
                </div>';
    }
}
