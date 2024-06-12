<?php

namespace App\Models\Person\Traits;

/**
 * Class PersonAttribute.
 */
trait PersonAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn">'.
            $this->getEditButtonAttribute('edit-person', 'admin.person.edit').
            $this->getDeleteButtonAttribute('delete-person', 'admin.person.destroy').
            $this->getShowButtonAttribute('btn btn-default btn-flat').
            '</div>';
    }

    /**
     * @return string
     */
    public function getShowButtonAttribute($class)
    {

        return '<a class="'.$class.'" href="'.route('admin.person.show', $this).'">
                    <i data-toggle="tooltip" data-placement="top" title="View" class="fa fa-eye"></i>
                </a>';

    }
}
