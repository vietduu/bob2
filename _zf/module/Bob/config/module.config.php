<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Bob\Controller\Index' => 'Bob\Controller\IndexController',
            'Bob\Controller\Cms' => 'Bob\Controller\CmsController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'layout/login' => __DIR__ . '/../view/layout/login.phtml',
            'layout/popup' => __DIR__ . '/../view/layout/popup.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'cms/bob/header' => __DIR__ . '/../view/cms/header.phtml',
            'cms/image' => __DIR__ . '/../view/cms/image.phtml',
            'bob/cms/index' => __DIR__ . '/../view/cms/index.phtml',
            'bob/cms/add' => __DIR__ . '/../view/cms/add-cms.phtml',
            'bob/cms/edit' => __DIR__ . '/../view/cms/edit-cms.phtml',
            'bob/cms/delete' => __DIR__ . '/../view/cms/delete-cms.phtml',
            'cms/detail' => __DIR__ . '/../view/cms/detail-cms.phtml',
            'bob/cms/image' => __DIR__ . '/../view/cms/image-manager.phtml',
        ),
        'template_path_stack' => array(
            'bobadmin' => __DIR__ . '/../view',
        ),
    ),
    'layouts' => array(
        'Bob' => array(
            'controllers' => array(
                'Index' => array(
                    'actions' => array(
                        'index' => 'layout/login'
                    ),
                    'default' => 'layout/layout'
                ),
                'Cms' => array(
                    'actions' => array(
                        'image' => 'layout/popup'
                    ),
                    'default' => 'layout/layout'
                ),
            ),
            'default' => 'layout/layout'
        )
    ),
);