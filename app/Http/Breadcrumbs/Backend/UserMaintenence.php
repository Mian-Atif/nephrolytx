<?php

Breadcrumbs::register('admin.usermaintenences.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.usermaintenences.management'), route('admin.usermaintenences.index'));
});

Breadcrumbs::register('admin.usermaintenences.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.usermaintenences.index');
    $breadcrumbs->push(trans('menus.backend.usermaintenences.create'), route('admin.usermaintenences.create'));
});

Breadcrumbs::register('admin.usermaintenences.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.usermaintenences.index');
    $breadcrumbs->push(trans('menus.backend.usermaintenences.edit'), route('admin.usermaintenences.edit', $id));
});
