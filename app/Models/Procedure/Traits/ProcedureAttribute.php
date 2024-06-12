<?php

namespace App\Models\Procedure\Traits;

/**
 * Class ProcedureAttribute.
 */
trait ProcedureAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-procedure", "admin.procedures.edit")}
                {$this->getDeleteButtonAttribute("delete-procedure", "admin.procedures.destroy")}
                </div>';
    }
}
