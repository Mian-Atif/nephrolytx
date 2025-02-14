<?php

namespace App\Models\CptCodeInsurancePrices\Traits;

/**
 * Class CptCodeInsurancePriceAttribute.
 */
trait CptCodeInsurancePriceAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-cptcodeinsuranceprice", "admin.cptcodeinsuranceprices.edit")}
                {$this->getDeleteButtonAttribute("delete-cptcodeinsuranceprice", "admin.cptcodeinsuranceprices.destroy")}
                </div>';
    }
}
