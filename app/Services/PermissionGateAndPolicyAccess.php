<?php

namespace App\Services;

use App\Policies\BottomPolicy;
use Illuminate\Support\Facades\Gate;
use App\Policies\CategoryNewPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\CommentNewPolicy;
use App\Policies\CommentPolicy;
use App\Policies\ComparePolicy;
use App\Policies\CompareProductPolicy;
use App\Policies\ContactIconPolicy;
use App\Policies\FilterPolicy;
use App\Policies\FilterProductPolicy;
use App\Policies\FooterPolicy;
use App\Policies\GroupPolicy;
use App\Policies\GroupProductPolicy;
use App\Policies\HeaderTagPolicy;
use App\Policies\PartnerPolicy;
use App\Policies\InforPolicy;
use App\Policies\ManyPolicy;
use App\Policies\MenuPolicy;
use App\Policies\NewPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ProductPolicy;
use App\Policies\QuestionPolicy;
use App\Policies\RolePolicy;
use App\Policies\SliderPolicy;
use App\Policies\UserPolicy;

class PermissionGateAndPolicyAccess {

    public function setGateAndPolicyAccess()
    {
        $this->defineCategory();
        $this->defineProduct();
        $this->defineCategoryNew();
        $this->defineNew();
        $this->defineQuestion();
        $this->defineHeaderTag();
        $this->defineHotline();
        $this->defineMenu();
        $this->defineSlider();
        $this->defineFooter();
        $this->defineBottom();
        $this->defineComment();
        $this->defineCommentNew();
        $this->definePartner();
        $this->defineContactIcon();
        $this->defineFilter();
        $this->defineFilterProduct();
        $this->defineCompare();
        $this->defineCompareProduct();
        $this->defineGroup();
        $this->defineGroupProduct();

        // Phân quyền nhiều loại khác
        $this->defineMany();

        $this->defineUser();
        $this->defineRole();
        $this->definePermission();
    }

    public function defineCategory()
    {
        // Gate::define('category-list', [CategoryPolicy::class, 'view']);
        Gate::define('category-add', [CategoryPolicy::class, 'create']);
        Gate::define('category-edit', [CategoryPolicy::class, 'update']);
        Gate::define('category-delete', [CategoryPolicy::class, 'delete']);
        Gate::define('category-checkbox', [CategoryPolicy::class, 'checkbox']);
        Gate::define('category-checkStt', [CategoryPolicy::class, 'checkStt']);
    }

    public function defineProduct()
    {
        // Gate::define('product-list', [ProductPolicy::class, 'view']);
        Gate::define('product-add', [ProductPolicy::class, 'create']);
        Gate::define('product-edit', [ProductPolicy::class, 'update']);
        Gate::define('product-delete', [ProductPolicy::class, 'delete']);
        Gate::define('product-checkbox', [ProductPolicy::class, 'checkbox']);
    }

    public function defineCategoryNew()
    {
        // Gate::define('cateNew-list', [CategoryNewPolicy::class, 'view']);
        Gate::define('cateNew-add', [CategoryNewPolicy::class, 'create']);
        Gate::define('cateNew-edit', [CategoryNewPolicy::class, 'update']);
        Gate::define('cateNew-delete', [CategoryNewPolicy::class, 'delete']);
        Gate::define('cateNew-checkbox', [CategoryNewPolicy::class, 'checkbox']);
        Gate::define('cateNew-checkStt', [CategoryNewPolicy::class, 'checkStt']);
    }

    public function defineNew()
    {
        // Gate::define('new-list', [NewPolicy::class, 'view']);
        Gate::define('new-add', [NewPolicy::class, 'create']);
        Gate::define('new-edit', [NewPolicy::class, 'update']);
        Gate::define('new-delete', [NewPolicy::class, 'delete']);
        Gate::define('new-checkbox', [NewPolicy::class, 'checkbox']);
    }

    public function defineQuestion()
    {
        Gate::define('question-add', [QuestionPolicy::class, 'create']);
        Gate::define('question-edit', [QuestionPolicy::class, 'update']);
        Gate::define('question-delete', [QuestionPolicy::class, 'delete']);
        Gate::define('question-checkbox', [QuestionPolicy::class, 'checkbox']);
    }

    public function defineHeaderTag()
    {
        Gate::define('header-tags-add', [HeaderTagPolicy::class, 'create']);
        Gate::define('header-tags-edit', [HeaderTagPolicy::class, 'update']);
        Gate::define('header-tags-delete', [HeaderTagPolicy::class, 'delete']);
        Gate::define('header-tags-checkbox', [HeaderTagPolicy::class, 'checkbox']);
    }

    public function defineHotline()
    {
        // Gate::define('hotline-list', [InforPolicy::class, 'view']);
        Gate::define('hotline-add', [InforPolicy::class, 'create']);
        Gate::define('hotline-edit', [InforPolicy::class, 'update']);
        Gate::define('hotline-delete', [InforPolicy::class, 'delete']);
        Gate::define('hotline-checkbox', [InforPolicy::class, 'checkbox']);
        Gate::define('hotline-checkStt', [InforPolicy::class, 'checkStt']);
    }

    public function defineMenu()
    {
        // Gate::define('menu-list', [MenuPolicy::class, 'view']);
        Gate::define('menu-add', [MenuPolicy::class, 'create']);
        Gate::define('menu-edit', [MenuPolicy::class, 'update']);
        Gate::define('menu-delete', [MenuPolicy::class, 'delete']);
        Gate::define('menu-checkbox', [MenuPolicy::class, 'checkbox']);
        Gate::define('menu-checkStt', [MenuPolicy::class, 'checkStt']);
    }

    public function defineSlider()
    {
        Gate::define('slider-add', [SliderPolicy::class, 'create']);
        Gate::define('slider-edit', [SliderPolicy::class, 'update']);
        Gate::define('slider-delete', [SliderPolicy::class, 'delete']);
        Gate::define('slider-checkbox', [SliderPolicy::class, 'checkbox']);
        Gate::define('slider-checkStt', [SliderPolicy::class, 'checkStt']);
    }

    public function defineFooter()
    {
        // Gate::define('footer-list', [FooterPolicy::class, 'view']);
        Gate::define('footer-add', [FooterPolicy::class, 'create']);
        Gate::define('footer-edit', [FooterPolicy::class, 'update']);
        Gate::define('footer-delete', [FooterPolicy::class, 'delete']);
        Gate::define('footer-checkbox', [FooterPolicy::class, 'checkbox']);
        Gate::define('footer-checkStt', [FooterPolicy::class, 'checkStt']);
    }

    public function defineBottom()
    {
        // Gate::define('bottom-list', [BottomPolicy::class, 'view']);
        Gate::define('bottom-add', [BottomPolicy::class, 'create']);
        Gate::define('bottom-edit', [BottomPolicy::class, 'update']);
        Gate::define('bottom-delete', [BottomPolicy::class, 'delete']);
        Gate::define('bottom-checkbox', [BottomPolicy::class, 'checkbox']);
        Gate::define('bottom-checkStt', [BottomPolicy::class, 'checkStt']);
    }

    public function definePartner()
    {
        Gate::define('partner-add', [PartnerPolicy::class, 'create']);
        Gate::define('partner-edit', [PartnerPolicy::class, 'update']);
        Gate::define('partner-delete', [PartnerPolicy::class, 'delete']);
        Gate::define('partner-checkbox', [PartnerPolicy::class, 'checkbox']);
        Gate::define('partner-checkStt', [PartnerPolicy::class, 'checkStt']);
    }

    public function defineContactIcon()
    {
        Gate::define('contact-icon-add', [ContactIconPolicy::class, 'create']);
        Gate::define('contact-icon-edit', [ContactIconPolicy::class, 'update']);
        Gate::define('contact-icon-delete', [ContactIconPolicy::class, 'delete']);
        Gate::define('contact-icon-checkbox', [ContactIconPolicy::class, 'checkbox']);
        Gate::define('contact-icon-checkStt', [ContactIconPolicy::class, 'checkStt']);
    }

    public function defineComment()
    {
        Gate::define('comment-edit', [CommentPolicy::class, 'update']);
        Gate::define('comment-delete', [CommentPolicy::class, 'delete']);
        Gate::define('comment-checkbox', [CommentPolicy::class, 'checkbox']);
        Gate::define('comment-checkStar', [CommentPolicy::class, 'checkStar']);
        Gate::define('comment-replay', [CommentPolicy::class, 'replay']);
    }

    public function defineCommentNew()
    {
        Gate::define('cmtNew-edit', [CommentNewPolicy::class, 'update']);
        Gate::define('cmtNew-delete', [CommentNewPolicy::class, 'delete']);
        Gate::define('cmtNew-checkbox', [CommentNewPolicy::class, 'checkbox']);
        Gate::define('cmtNew-checkStar', [CommentNewPolicy::class, 'checkStar']);
        Gate::define('cmtNew-replay', [CommentNewPolicy::class, 'replay']);
    }

    public function defineFilter()
    {
        // Gate::define('filter-list', [FilterPolicy::class, 'view']);
        Gate::define('filter-add', [FilterPolicy::class, 'create']);
        Gate::define('filter-edit', [FilterPolicy::class, 'update']);
        Gate::define('filter-delete', [FilterPolicy::class, 'delete']);
        Gate::define('filter-checkbox', [FilterPolicy::class, 'checkbox']);
        Gate::define('filter-checkStt', [FilterPolicy::class, 'checkStt']);
    }

    public function defineFilterProduct()
    {
        Gate::define('filterPro-add', [FilterProductPolicy::class, 'create']);
        Gate::define('filterPro-edit', [FilterProductPolicy::class, 'update']);
    }

    public function defineCompare()
    {
        // Gate::define('compare-list', [ComparePolicy::class, 'view']);
        Gate::define('compare-add', [ComparePolicy::class, 'create']);
        Gate::define('compare-edit', [ComparePolicy::class, 'update']);
        Gate::define('compare-delete', [ComparePolicy::class, 'delete']);
        Gate::define('compare-checkbox', [ComparePolicy::class, 'checkbox']);
        Gate::define('compare-checkStt', [ComparePolicy::class, 'checkStt']);
    }

    public function defineCompareProduct()
    {
        Gate::define('comparePro-add', [CompareProductPolicy::class, 'create']);
        Gate::define('comparePro-edit', [CompareProductPolicy::class, 'update']);
    }

    public function defineGroup()
    {
        Gate::define('group-add', [GroupPolicy::class, 'create']);
        Gate::define('group-edit', [GroupPolicy::class, 'update']);
        Gate::define('group-delete', [GroupPolicy::class, 'delete']);
        Gate::define('group-checkbox', [GroupPolicy::class, 'checkbox']);
        Gate::define('group-checkStt', [GroupPolicy::class, 'checkStt']);
    }

    public function defineGroupProduct()
    {
        Gate::define('groupPro-add', [GroupProductPolicy::class, 'create']);
        Gate::define('groupPro-edit', [GroupProductPolicy::class, 'update']);
    }

    // Phân quyền nhiều loại khác nhau
    public function defineMany()
    {
        Gate::define('quote-list', [ManyPolicy::class, 'listQuotes']);
        Gate::define('quote-checkbox', [ManyPolicy::class, 'checkboxQuotes']);
        Gate::define('setting-edit', [ManyPolicy::class, 'settingEdit']);
    }

    public function defineUser()
    {
        Gate::define('user-list', [UserPolicy::class, 'view']);
        Gate::define('user-add', [UserPolicy::class, 'create']);
        Gate::define('user-edit', [UserPolicy::class, 'update']);
        Gate::define('user-delete', [UserPolicy::class, 'delete']);
    }

    public function defineRole()
    {
        Gate::define('role-list', [RolePolicy::class, 'view']);
        Gate::define('role-add', [RolePolicy::class, 'create']);
        Gate::define('role-edit', [RolePolicy::class, 'update']);
        Gate::define('role-delete', [RolePolicy::class, 'delete']);
    }

    public function definePermission()
    {
        Gate::define('permission-list', [PermissionPolicy::class, 'view']);
        Gate::define('permission-add', [PermissionPolicy::class, 'create']);
        Gate::define('permission-edit', [PermissionPolicy::class, 'update']);
        Gate::define('permission-delete', [PermissionPolicy::class, 'delete']);
    }
}