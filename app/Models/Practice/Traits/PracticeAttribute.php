<?php

namespace App\Models\Practice\Traits;

/**
 * Class PracticeAttribute.
 */
trait PracticeAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    //            $this->getEditButtonAttribute('edit-practice', 'admin.practices.edit').

    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn">
            '.$this->getEditButtonAttribute('edit-practices', 'admin.practices.edit').'
            '.$this->getShowButtonAttribute('btn btn-default btn-flat').'

            '.$this->getDeleteButtonAttribute('delete-practice', 'admin.practices.destroy').'
            </div>';
    }

    /**
     * @return string
     */
    public function getShowButtonAttribute($class)
    {

            return '<a class="'.$class.'" href="'.route('admin.practices.show', $this).'">
                    <i data-toggle="tooltip" data-placement="top" title="View" class="fa fa-eye"></i>
                </a>';

    }
}
