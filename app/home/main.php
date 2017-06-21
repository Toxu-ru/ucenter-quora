<?php
/*
+--------------------------------------------------------------------------
|   WeCenter [#RELEASE_VERSION#]
|   ========================================
|   by WeCenter Software
|   © 2011 - 2014 WeCenter. All Rights Reserved
|   and dev Evg
|   ========================================
|
+---------------------------------------------------------------------------
*/


if (!defined('IN_ANWSION'))
{
	die;
}

class main extends AWS_CONTROLLER
{
	public function get_access_rule()
	{
		$rule_action['rule_type'] = 'white';
		$rule_action['actions'] = array(
			'explore'
		);

		if ($this->user_info['permission']['visit_explore'] AND $this->user_info['permission']['visit_site'])
		{
			$rule_action['actions'][] = 'index';
		}

		return $rule_action;
	}

	public function setup()
	{
		if (is_mobile() AND !$_GET['ignore_ua_check'])
		{
			switch ($_GET['app'])
			{
				default:
					HTTP::redirect('/m/');
				break;
			}
		}
	}

	public function index_action()
	{		
		if (! $this->user_id)
		{
			HTTP::redirect('/explore/');
		}

		if (! $this->user_info['email'])
		{
			HTTP::redirect('/account/complete_profile/');
		}

		//Люди могут быть заинтересованы в боковой панели или темы
		if (TPL::is_output('block/sidebar_recommend_users_topics.tpl.htm', 'home/index'))
		{
			$recommend_users_topics = $this->model('module')->recommend_users_topics($this->user_id);

			TPL::assign('sidebar_recommend_users_topics', $recommend_users_topics);
		}

		// Боковой Топ
		if (TPL::is_output('block/sidebar_hot_users.tpl.htm', 'home/index'))
		{
			$sidebar_hot_users = $this->model('module')->sidebar_hot_users($this->user_id);

			TPL::assign('sidebar_hot_users', $sidebar_hot_users);
		}

		$this->crumb(AWS_APP::lang()->_t('Главная'), '/home/');

		TPL::import_js('js/app/index.js');

		TPL::output('home/index');
	}

	public function explore_action()
	{
		HTTP::redirect('/explore/');
	}
}
