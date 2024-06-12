<?php

Breadcrumbs::register('admin.practiceusers.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.practiceusers.management'), route('admin.practiceusers.index'));
});

Breadcrumbs::register('admin.practiceusers.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.practiceusers.index');
    $breadcrumbs->push(trans('menus.backend.practiceusers.create'), route('admin.practiceusers.create'));
});

Breadcrumbs::register('admin.practiceusers.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.practiceusers.index');
    $breadcrumbs->push(trans('menus.backend.practiceusers.edit'), route('admin.practiceusers.edit', $id));
});
