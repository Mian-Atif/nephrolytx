<?php

namespace App\Models\AgingSummary\Traits;

/**
 * Class AgingSummaryAttribute.
 */
trait AgingSummaryAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-agingsummary", "admin.agingsummaries.edit")}
                {$this->getDeleteButtonAttribute("delete-agingsummary", "admin.agingsummaries.destroy")}
                </div>';
    }
}
