<?php
/*
+--------------------------------------------------------------------------
|   WeCenter [#RELEASE_VERSION#]
|   ========================================
|   by WeCenter Software
|   © 2011 - 2014 WeCenter. All Rights Reserved
|   ========================================
|   © 2017 and dev Evg
|
+---------------------------------------------------------------------------
*/

require_once('../system/init.php');

HTTP::no_cache_header();

if (file_exists(AWS_PATH . 'config/install.lock.php'))
{
	H::redirect_msg(load_class('core_lang')->_t('Ваша программа была установлена. Для повторной установки удалите: system/config/install.lock.php'));
}

@set_time_limit(0);

TPL::assign('page_title', 'WeCenter - Install');
TPL::assign('static_url', '../static');

switch ($_POST['step'])
{
	default :
		$system_require = array();

		if (version_compare(PHP_VERSION, ENVIRONMENT_PHP_VERSION, '>=') AND get_cfg_var('safe_mode') == false)
		{
			$system_require['php'] = TRUE;
		}

		if (class_exists('PDO', false))
		{
			if (defined('PDO::MYSQL_ATTR_USE_BUFFERED_QUERY'))
			{
				$system_require['db'] = 'PDO_MYSQL';
			}
		}

		if (!$system_require['db'] AND function_exists('mysqli_close'))
		{
			$system_require['db'] = 'MySQLi';
		}

		if (function_exists('session_start'))
		{
			$system_require['session'] = TRUE;
		}

		if (function_exists('iconv'))
		{
			$system_require['convert_encoding'] = TRUE;
		}

		if (isset($_COOKIE))
		{
			$system_require['cookie'] = TRUE;
		}

		if (function_exists('gd_info'))
		{
			$system_require['image_lib'] = 'GD';
		}

		if ($system_require['image_lib'] AND class_exists('Imagick', false))
		{
			$system_require['image_lib'] = 'ImageMagick';
		}

		if (function_exists('ctype_xdigit'))
		{
			$system_require['ctype'] = TRUE;
		}

		if (function_exists('curl_exec'))
		{
			$system_require['curl'] = TRUE;
		}

		if (function_exists('imageftbbox'))
		{
			$system_require['ft_font'] = TRUE;
		}
		
		if (function_exists('mcrypt_module_open'))
		{
			$system_require['mcrypt'] = TRUE;
		}

		if (function_exists('gzcompress'))
		{
			$system_require['zlib'] = TRUE;
		}
		
		// AWS_PATH 
		if (is_really_writable(AWS_PATH) OR defined('IN_SAE'))
		{
			$system_require['config_writable_core'] = TRUE;
		}

		//  AWS_PATH /config/ 
		if (is_really_writable(AWS_PATH . 'config/') OR defined('IN_SAE'))
		{
			$system_require['config_writable_config'] = TRUE;
		}

		$base_dir = str_replace("\\", "",dirname(dirname($_SERVER['PHP_SELF'])));

		if (!defined('IN_SAE'))
		{
			if (!@file_get_contents('http://api.weibo.com/'))
			{
				$error_messages[] = load_class('core_lang')->_t('Не возможно установить связь с weibo');
			}

			if (!@gethostbyname('graph.qq.com'))
			{
				$error_messages[] = load_class('core_lang')->_t('Не возможно установить связь с QQ');
			}
		}

		TPL::assign('error_messages', $error_messages);
		TPL::assign('system_require', $system_require);
		TPL::assign('base_dir', $base_dir);

		TPL::output('install/index');
		break;

	case 2 :
		if (!defined('IN_SAE'))
		{
			$data_dir = array(
				'tmp',
				'cache',
				'uploads'
			);

			foreach ($data_dir as $key => $dir_name)
			{
				if (! is_dir(ROOT_PATH . $dir_name))
				{
					if (! @mkdir(ROOT_PATH . $dir_name))
					{
						$error_messages[] = load_class('core_lang')->_t('Каталог: %s не удается создать. Установите: 777, разрешения', ROOT_PATH . $dir_name);
					}
				}
			}

			if (! is_really_writable(AWS_PATH))
			{
				$error_messages[] = load_class('core_lang')->_t('В каталог: %s не дается записать. Установите: 777 разрешение', AWS_PATH);
			}
		}

		if (class_exists('PDO', false))
		{
			if (defined('PDO::MYSQL_ATTR_USE_BUFFERED_QUERY'))
			{
				TPL::assign('pdo_support', TRUE);
			}
		}

		if (function_exists('mysqli_close'))
		{
			TPL::assign('mysqi_support', TRUE);
		}

		TPL::assign('error_messages', $error_messages);
		TPL::output('install/settings');
		break;

	case 3 :
		if (defined('IN_SAE'))
		{
			$db_config = array(
			  'host' => SAE_MYSQL_HOST_M,
			  'port' => SAE_MYSQL_PORT,
			  'username' =>  SAE_MYSQL_USER,
			  'password' => SAE_MYSQL_PASS,
			  'dbname' => SAE_MYSQL_DB,
			  'charset' => 'utf8'
			);
		}
		else
		{
			$db_config = array(
				'charset' => 'utf8',
				'host' => $_POST['db_host'],
				'username' => $_POST['db_username'],
				'password' => $_POST['db_password'],
				'dbname' => $_POST['db_dbname']
			);

			if ($_POST['db_port'])
			{
				$db_config['port'] = $_POST['db_port'];
			}

			if ($_POST['db_driver'])
			{
				$db_driver = $_POST['db_driver'];
			}
			else if (class_exists('PDO', false))
			{
				if (defined('PDO::MYSQL_ATTR_USE_BUFFERED_QUERY'))
				{
					$db_driver = 'PDO_MYSQL';
				}
			}
		}

		if (!$db_driver)
		{
			$db_driver = 'MySQLi';
		}

		if (!$_POST['db_engine'])
		{
			$_POST['db_engine'] = 'MyISAM';
		}

		try
		{
			$db = Zend_Db::factory($db_driver, $db_config);
		}
		catch (Exception $e)
		{
			H::redirect_msg(load_class('core_lang')->_t('Соединение с базой, не удается:') . ' ' . strip_tags($e->getMessage()), './');
		}

		try
		{
			$tables = $db->fetchAll('SHOW TABLES');
		}
		catch (Exception $e)
		{
			H::redirect_msg(load_class('core_lang')->_t('Соединение с базой, не удается:') . ' ' . strip_tags($e->getMessage()), './');
		}

		if (number_format($db->getServerVersion(), 1) < 5)
		{
			H::redirect_msg(load_class('core_lang')->_t('Установка прервана. Требуется MySQL 5.0 и выше. Ваша версия: %s', $db->getServerVersion()), './');
		}

		if (!$_POST['db_prefix'] AND count($tables) > 0)
		{
			H::redirect_msg(load_class('core_lang')->_t('Таблицы с данными базы уже существуют'), './');
		}

		foreach ($tables AS $key => $table_info)
		{
			if (!is_array($table_info))
			{
				break;
			}

			foreach ($table_info AS $_key => $table)
			{
				if (substr($table, 0, strlen($_POST['db_prefix'])) == $_POST['db_prefix'])
				{
					H::redirect_msg(load_class('core_lang')->_t('База данных уже существует с теми же таблицами и префиксом'), './');

					break;
				}
			}
		}

		if (!defined('IN_SAE'))
		{
			$config = array(
				'charset' => 'utf8',
				'prefix' => $_POST['db_prefix'],
				'driver' => $db_driver,
				'master' => $db_config,
				'slave' => false
			);

			if ($_POST['db_port'])
			{
				$config['port'] = $_POST['db_port'];
			}

			load_class('core_config')->set('database', $config);
		}

		// Создание таблицы данных
		$db_table_querys = explode(";\r", str_replace(array('[#DB_PREFIX#]', '[#DB_ENGINE#]', "\n"), array($_POST['db_prefix'], $_POST['db_engine'], "\r"), file_get_contents(ROOT_PATH . 'install/db/mysql.sql')));

		foreach ($db_table_querys as $_sql)
		{
			if ($query_string = trim(str_replace(array(
				"\r",
				"\n",
				"\t"
			), '', $_sql)))
			{
				$db->query($query_string);
			}
		}

		$db->insert($_POST['db_prefix'] . 'system_setting', array(
			'varname' => 'db_engine',
			'value' => 's:' . strlen($_POST['db_engine']) . ':"' . $_POST['db_engine'] . '";',
		));

		TPL::output('install/final');
		break;

	case 4 :
		$db = load_class('core_db')->setObject('master');
		$db_prefix = load_class('core_config')->get('database')->prefix;

		$salt = fetch_salt(4);

		$data = array(
			'user_name' => $_POST['user_name'],
			'password' => compile_password($_POST['password'], $salt),
			'email' => $_POST['email'],
			'salt' => $salt,
			'group_id' => 1,
			'reputation_group' => 5,
			'valid_email' => 1,
			'is_first_login' => 1,
			'reg_time' => time(),
			'reg_ip' => ip2long(fetch_ip()),
			'last_login' => time(),
			'last_ip' => ip2long(fetch_ip()),
			'last_active' => time(),
			'invitation_available' => 10,
			'integral' => 2000
		);

		$db->insert($db_prefix . 'users', $data);
		$db->insert($db_prefix . 'users_attrib', array('uid' => 1, 'signature' => ''));

		$db->insert($db_prefix . 'integral_log', array(
			 'uid' => 1,
			 'action' => 'REGISTER',
			 'integral' => 2000,
			 'note' => load_class('core_lang')->_t('Начало'),
			 'balance' => 2000,
			 'time' => time()
		));

		// Загрузить конфигурацию веб-сайта
		$base_dir = dirname(dirname($_SERVER['PHP_SELF']));
		$base_dir = ($base_dir == DIRECTORY_SEPARATOR) ? '' : $base_dir;

		$insert_query = file_get_contents(ROOT_PATH . 'install/db/system_setting.sql');

		$insert_query = str_replace('[#DB_PREFIX#]', $db_prefix, $insert_query);
		
		if (defined('IN_SAE'))
		{
			$insert_query = str_replace('[#UPLOAD_URL#]', serialize($_POST['upload_url']), $insert_query);
			$insert_query = str_replace('[#UPLOAD_DIR#]', serialize('saestor://uploads'), $insert_query);
		}
		else
		{
			$base_url = base_url();

			if (substr($base_url, -8) == '/install')
			{
				$base_url = substr_replace($base_url, '', -8);
			}

			$insert_query = str_replace('[#UPLOAD_URL#]', serialize($base_url . "/uploads"), $insert_query);
			$insert_query = str_replace('[#UPLOAD_DIR#]', serialize(str_replace("\\", "/", ROOT_PATH) . "uploads"), $insert_query);
		}

		$insert_query = str_replace('[#FROM_EMAIL#]', serialize($_POST['email']), $insert_query);
		$insert_query = str_replace('[#DB_VERSION#]', serialize(G_VERSION_BUILD), $insert_query);

		$insert_query = str_replace("\r", '', $insert_query);

		$insert_query = explode("\n", $insert_query);
		
		unset($insert_query[0]);

		foreach ($insert_query AS $_sql)
		{
			$insert_vars = explode("', '", ltrim(rtrim(rtrim(rtrim($_sql, ','), ';'), ')'), '('));
						
			try {
				$db->insert($db_prefix . 'system_setting', array(
					'varname' => ltrim($insert_vars[0], "'"),
					'value' => rtrim($insert_vars[1], "'")
				));
			}
			catch (Exception $e)
			{
				die('SQL Error: ' . $e->getMessage() . '<br /><br />Query: ' . json_encode(array(
					'varname' => ltrim($insert_vars[0], "'"),
					'value' => rtrim($insert_vars[1], "'")
				)));
			}
		}

		$db->insert($db_prefix . 'system_setting', array(
			'varname' => 'register_agreement',
			'value' => serialize(file_get_contents(ROOT_PATH . 'install/db/register_agreement.txt')),
		));

		if (!defined('IN_SAE'))
		{
			$config_file = file_get_contents(AWS_PATH . 'config.dist.php');
			$config_file = str_replace('{G_COOKIE_PREFIX}', fetch_salt(3) . '_', $config_file);
			$config_file = str_replace('{G_SECUKEY}', fetch_salt(12), $config_file);
			$config_file = str_replace('{G_COOKIE_HASH_KEY}', fetch_salt(15), $config_file);

			file_put_contents(AWS_PATH . 'config.inc.php', $config_file);
			file_put_contents(AWS_PATH . 'config/install.lock.php', time());
		}

		TPL::output('install/success');
		break;
}
