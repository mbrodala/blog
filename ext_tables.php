<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

call_user_func(function () {
    $blogDocType = \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST;

    // Add new page type:
    $GLOBALS['PAGES_TYPES'][$blogDocType] = [
        'type' => 'web',
        'allowedTables' => '*',
    ];

    // Provide icon for page tree, list view, ... :
    $icons = [
        'blog-link-wizard' => 'EXT:blog/Resources/Public/Icons/blog-link-wizard.svg',
        'apps-pagetree-folder-contains-blog' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-folder-contains-blog.svg',
        'apps-pagetree-blog' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog.svg',
        'apps-pagetree-blog-category' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-category.svg',
        'apps-pagetree-blog-comment' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-comment.svg',
        'apps-pagetree-blog-comment-approved' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-comment-approved.svg',
        'apps-pagetree-blog-comment-blocked' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-comment-blocked.svg',
        'apps-pagetree-blog-comment-todo' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-comment-todo.svg',
        'apps-pagetree-blog-post' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-post.svg',
        'apps-pagetree-blog-tag' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-tag.svg',
    ];
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    foreach ($icons as $identifier => $path) {
        $iconRegistry->registerIcon(
            $identifier,
            TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => $path]
        );
    }

    // Allow backend users to drag and drop the new page type:
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig(
        'options.pageTree.doktypesToShowInNewPageDragArea := addToList(' . $blogDocType . ')'
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_blog_domain_model_comment');

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'T3G.AgencyPack.Blog',
        'Posts',
        'Blog: List of posts'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'T3G.AgencyPack.Blog',
        'Category',
        'Blog: List by category'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'T3G.AgencyPack.Blog',
        'Tag',
        'Blog: List by tags'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'T3G.AgencyPack.Blog',
        'Archive',
        'Blog: Archive'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'T3G.AgencyPack.Blog',
        'Sidebar',
        'Blog: Sidebar'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'T3G.AgencyPack.Blog',
        'Metadata',
        'Blog: Metadata'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'T3G.AgencyPack.Blog',
        'CommentForm',
        'Blog: Comment form'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'T3G.AgencyPack.Blog',
        'Comments',
        'Blog: Comments'
    );

    if (TYPO3_MODE === 'BE') {
        // Module System > Backend Users
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'T3G.AgencyPack.Blog',
            'system',
            'tx_Blog',
            'top',
            [
                'Backend' => 'index, createBlog, posts'
            ],
            [
                'access' => 'admin',
                'icon' => 'EXT:blog/Resources/Public/Icons/module-blog.svg',
                'labels' => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod.xlf'
            ]
        );
    }
});
