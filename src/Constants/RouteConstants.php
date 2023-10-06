<?php

namespace App\Constants;

class RouteConstants
{
    // Security
    const LOGIN = 'app.login';
    const REGISTER = 'app.register';

    // Frontend
    const HOME = 'app.home';

    // Backend
    // Articles
    const ADMIN_ARTICLES = 'app.admin.articles';
    const ADMIN_ARTICLE_CREATE = 'app.admin.articles.create';
    const ADMIN_ARTICLE_ITEM = 'app.admin.articles.item';
    const ADMIN_ARTICLE_EDIT = 'app.admin.articles.edit';
    const ADMIN_ARTICLE_DELETE = 'app.admin.articles.delete';
    const ADMIN_CATEGORIES = 'app.admin.categories';
    const ADMIN_CATEGORIES_CREATE = 'app.admin.categories.create';
    const ADMIN_CATEGORIES_ITEM = 'app.admin.categories.item';
    const ADMIN_CATEGORIES_EDIT = 'app.admin.categories.edit';
    const ADMIN_CATEGORIES_DELETE = 'app.admin.categories.delete';
    const ADMIN_CATEGORIES_VISIBILITY = 'app.admin.categories.visibility';
}