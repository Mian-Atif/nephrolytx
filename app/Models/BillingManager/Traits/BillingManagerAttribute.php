<?php

namespace App\Models\BillingManager\Traits;

/**
 * Class BillingManagerAttribute.
 */
trait BillingManagerAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-billingmanager", "admin.billingmanagers.edit")}
                {$this->getDeleteButtonAttribute("delete-billingmanager", "admin.billingmanagers.destroy")}
                </div>';
    }
}
