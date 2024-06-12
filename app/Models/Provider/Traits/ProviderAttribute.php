<?php

namespace App\Models\Provider\Traits;

/**
 * Class ProviderAttribute.
 */
trait ProviderAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-provider", "admin.providers.edit")}
                {$this->getDeleteButtonAttribute("delete-provider", "admin.providers.destroy")}
                </div>';
    }
}
