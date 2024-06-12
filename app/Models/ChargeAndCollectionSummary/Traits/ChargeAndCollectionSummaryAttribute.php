<?php

namespace App\Models\ChargeAndCollectionSummary\Traits;

/**
 * Class ChargeAndCollectionSummaryAttribute.
 */
trait ChargeAndCollectionSummaryAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-chargeandcollectionsummary", "admin.chargeandcollectionsummaries.edit")}
                {$this->getDeleteButtonAttribute("delete-chargeandcollectionsummary", "admin.chargeandcollectionsummaries.destroy")}
                </div>';
    }
}
