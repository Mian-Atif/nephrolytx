<?php

Breadcrumbs::register('admin.practiceprofiles.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.practiceprofiles.management'), route('admin.practiceprofiles.index'));
});

Breadcrumbs::register('admin.practiceprofiles.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.practiceprofiles.index');
    $breadcrumbs->push(trans('menus.backend.practiceprofiles.create'), route('admin.practiceprofiles.create'));
});

Breadcrumbs::register('admin.practiceprofiles.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.practiceprofiles.index');
    $breadcrumbs->push(trans('menus.backend.practiceprofiles.edit'), route('admin.practiceprofiles.edit', $id));
});
