<?php

Breadcrumbs::register('admin.practiceusermanagements.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.practiceusermanagements.management'), route('admin.practiceusermanagements.index'));
});

Breadcrumbs::register('admin.practiceusermanagements.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.practiceusermanagements.index');
    $breadcrumbs->push(trans('menus.backend.practiceusermanagements.create'), route('admin.practiceusermanagements.create'));
});

Breadcrumbs::register('admin.practiceusermanagements.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.practiceusermanagements.index');
    $breadcrumbs->push(trans('menus.backend.practiceusermanagements.edit'), route('admin.practiceusermanagements.edit', $id));
});
