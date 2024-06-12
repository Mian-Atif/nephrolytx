<?php

namespace App\Models\TransactionAnalysis\Traits;

/**
 * Class TransactionAnalysiAttribute.
 */
trait TransactionAnalysiAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-transactionanalysi", "admin.transactionanalysis.edit")}
                {$this->getDeleteButtonAttribute("delete-transactionanalysi", "admin.transactionanalysis.destroy")}
                </div>';
    }
}
