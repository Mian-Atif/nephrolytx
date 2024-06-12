<?php

namespace App\Models\Payer\Traits;

/**
 * Class PayerAttribute.
 */
trait PayerAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-payer", "admin.payers.edit")}
                {$this->getDeleteButtonAttribute("delete-payer", "admin.payers.destroy")}
                </div>';
    }
}
