<?php

Breadcrumbs::register('admin.cptcodes.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.cptcodes.management'), route('admin.cptcodes.index'));
});

Breadcrumbs::register('admin.cptcodes.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.cptcodes.index');
    $breadcrumbs->push(trans('menus.backend.cptcodes.create'), route('admin.cptcodes.create'));
});

Breadcrumbs::register('admin.cptcodes.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.cptcodes.index');
    $breadcrumbs->push(trans('menus.backend.cptcodes.edit'), route('admin.cptcodes.edit', $id));
});
