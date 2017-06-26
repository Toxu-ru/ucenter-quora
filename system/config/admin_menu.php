<?php
$config[] = array(
    'title' => AWS_APP::lang()->_t('Главная'),
    'cname' => 'home',
    'url' => 'admin/',
    'children' => array()
);

$config[] = array(
    'title' => AWS_APP::lang()->_t('Глобавльные'),
    'cname' => 'setting',
    'children' => array(
        array(
            'id' => 'SETTINGS_SITE',
            'title' => AWS_APP::lang()->_t('Сайт'),
            'url' => 'admin/settings/category-site'
        ),

        array(
            'id' => 'SETTINGS_REGISTER',
            'title' => AWS_APP::lang()->_t('Регистрация'),
            'url' => 'admin/settings/category-register'
        ),

        array(
            'id' => 'SETTINGS_FUNCTIONS',
            'title' => AWS_APP::lang()->_t('Возможности'),
            'url' => 'admin/settings/category-functions'
        ),

        array(
            'id' => 'SETTINGS_CONTENTS',
            'title' => AWS_APP::lang()->_t('Содержимое'),
            'url' => 'admin/settings/category-contents'
        ),

        array(
            'id' => 'SETTINGS_INTEGRAL',
            'title' => AWS_APP::lang()->_t('Баллы'),
            'url' => 'admin/settings/category-integral'
        ),

        array(
            'id' => 'SETTINGS_PERMISSIONS',
            'title' => AWS_APP::lang()->_t('Права'),
            'url' => 'admin/settings/category-permissions'
        ),

        array(
            'id' => 'SETTINGS_MAIL',
            'title' => AWS_APP::lang()->_t('Почта'),
            'url' => 'admin/settings/category-mail'
        ),

        array(
            'id' => 'SETTINGS_OPENID',
            'title' => AWS_APP::lang()->_t('OpenID'),
            'url' => 'admin/settings/category-openid'
        ),

        array(
            'id' => 'SETTINGS_CACHE',
            'title' => AWS_APP::lang()->_t('Кеш'),
            'url' => 'admin/settings/category-cache'
        ),

        array(
            'id' => 'SETTINGS_INTERFACE',
            'title' => AWS_APP::lang()->_t('Интерфейс'),
            'url' => 'admin/settings/category-interface'
        )
    )
);

$config[] = array(
    'title' => AWS_APP::lang()->_t('Содержания'),
    'cname' => 'reply',
    'children' => array(
        array(
            'id' => 301,
            'title' => AWS_APP::lang()->_t('Вопросы'),
            'url' => 'admin/question/question_list/'
        ),

        array(
            'id' => 309,
            'title' => AWS_APP::lang()->_t('Статьи'),
            'url' => 'admin/article/list/'
        ),

        array(
            'id' => 303,
            'title' => AWS_APP::lang()->_t('Темы'),
            'url' => 'admin/topic/list/'
        )
    )
);

$config[] = array(
    'title' => AWS_APP::lang()->_t('Участники'),
    'cname' => 'user',
    'children' => array(
        array(
            'id' => 402,
            'title' => AWS_APP::lang()->_t('Список'),
            'url' => 'admin/user/list/'
        ),

        array(
            'id' => 403,
            'title' => AWS_APP::lang()->_t('Группы'),
            'url' => 'admin/user/group_list/'
        ),

        array(
            'id' => 406,
            'title' => AWS_APP::lang()->_t('Инвайты'),
            'url' => 'admin/user/invites/'
        ),

        array(
            'id' => 407,
            'title' => AWS_APP::lang()->_t('Работа'),
            'url' => 'admin/user/job_list/'
        )
    )
);

$config[] = array(
    'title' => AWS_APP::lang()->_t('Управление'),
    'cname' => 'report',
    'children' => array(
        array(
            'id' => 300,
            'title' => AWS_APP::lang()->_t('Список'),
            'url' => 'admin/approval/list/'
        ),

        array(
            'id' => 401,
            'title' => AWS_APP::lang()->_t('Сертифик'),
            'url' => 'admin/user/verify_approval_list/'
        ),

        array(
            'id' => 408,
            'title' => AWS_APP::lang()->_t('Регистр.'),
            'url' => 'admin/user/register_approval_list/'
        ),

        array(
            'id' => 306,
            'title' => AWS_APP::lang()->_t('Жалобы'),
            'url' => 'admin/question/report_list/'
        )
    )
);

if (check_extension_package('project'))
{
    $config[] = array(
        'title' => 'События',
        'cname' => 'reply',
        'children' => array(
            array(
                'id' => 310,
                'title' => 'Список',
                'url' => 'admin/project/project_list/'
            ),

            array(
                'id' => 311,
                'title' => 'Деятельность',
                'url' => 'admin/project/approval_list/'
            ),

            array(
                'id' => 312,
                'title' => 'Заказы',
                'url' => 'admin/project/order_list/'
            )
        )
    );
}

$config[] = array(
    'title' => AWS_APP::lang()->_t('Коннект'),
    'cname' => 'signup',
    'children' => array(
        array(
            'id' => 307,
            'title' => AWS_APP::lang()->_t('Меню'),
            'url' => 'admin/nav_menu/'
        ),

        array(
            'id' => 302,
            'title' => AWS_APP::lang()->_t('Категории'),
            'url' => 'admin/category/list/'
        ),

        array(
            'id' => 304,
            'title' => AWS_APP::lang()->_t('Темы'),
            'url' => 'admin/feature/list/'
        ),

        array(
            'id' => 308,
            'title' => AWS_APP::lang()->_t('Страницы'),
            'url' => 'admin/page/'
        ),

        array(
            'id' => 305,
            'title' => AWS_APP::lang()->_t('FAQ'),
            'url' => 'admin/help/list/'
        )
    )
);

$config[] = array(
    'title' => AWS_APP::lang()->_t('Интеграция'),
    'cname' => 'share',
    'children' => array(
        array(
            'id' => 802,
            'title' => AWS_APP::lang()->_t('weixin'),
            'url' => 'admin/weixin/accounts/'
        ),

        array(
            'id' => 803,
            'title' => AWS_APP::lang()->_t('weixin меню'),
            'url' => 'admin/weixin/mp_menu/'
        ),

        array(
            'id' => 801,
            'title' => AWS_APP::lang()->_t('weixin репли'),
            'url' => 'admin/weixin/reply/'
        ),

        array(
            'id' => 808,
            'title' => AWS_APP::lang()->_t('weixin +'),
            'url' => 'admin/weixin/third_party_access/'
        ),

        array(
            'id' => 805,
            'title' => AWS_APP::lang()->_t('weixin код'),
            'url' => 'admin/weixin/qr_code/'
        ),

        array(
            'id' => 804,
            'title' => AWS_APP::lang()->_t('weixin лист'),
            'url' => 'admin/weixin/sent_msgs_list/'
        ),

        array(
            'id' => 806,
            'title' => AWS_APP::lang()->_t('weixin сообщ'),
            'url' => 'admin/weibo/msg/'
        ),

        array(
            'id' => 807,
            'title' => AWS_APP::lang()->_t('Почти инпорт'),
            'url' => 'admin/edm/receiving_list/'
        )
    )
);

$config[] = array(
    'title' => AWS_APP::lang()->_t('Почта'),
    'cname' => 'inbox',
    'children' => array(
        array(
            'id' => 702,
            'title' => AWS_APP::lang()->_t('задачи'),
            'url' => 'admin/edm/tasks/'
        ),

        array(
            'id' => 701,
            'title' => AWS_APP::lang()->_t('Группы'),
            'url' => 'admin/edm/groups/'
        )
    )
);

$config[] = array(
    'title' => AWS_APP::lang()->_t('Инструменты'),
    'cname' => 'job',
    'children' => array(
        array(
            'id' => 501,
            'title' => AWS_APP::lang()->_t('Обслуживание'),
            'url' => 'admin/tools/',
        )
    )
);

if (file_exists(AWS_PATH . 'config/admin_menu.extension.php'))
{
    include_once(AWS_PATH . 'config/admin_menu.extension.php');
}
