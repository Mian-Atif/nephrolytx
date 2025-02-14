<?php

namespace App\Models\AnalysisReport\Traits;

/**
 * Class AnalysisReportAttribute.
 */
trait AnalysisReportAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-analysisreport", "admin.analysisreports.edit")}
                {$this->getDeleteButtonAttribute("delete-analysisreport", "admin.analysisreports.destroy")}
                </div>';
    }
}
