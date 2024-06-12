<?php

namespace App\Models\PerformanceReport\Traits;

/**
 * Class PerformanceReportAttribute.
 */
trait PerformanceReportAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-performancereport", "admin.performancereports.edit")}
                {$this->getDeleteButtonAttribute("delete-performancereport", "admin.performancereports.destroy")}
                </div>';
    }
}
