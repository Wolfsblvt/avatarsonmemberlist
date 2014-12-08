<?php
/**
 * 
 * Avatars on Memberlist
 * 
 * @copyright (c) 2014 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\avatarsonmemberlist\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	/** @var \Symfony\Component\DependencyInjection\ContainerInterface */
	protected $container;
	
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;
	
	/** @var \phpbb\config\config */
	protected $config;
	
	/** @var \phpbb\path_helper */
	protected $path_helper;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpEx */
	protected $php_ext;

	/**
	 * Constructor of event listener
	 *
	 * @param \phpbb\db\driver\driver_interface		$db				Database
	 * @param \phpbb\config\config					$config			Config helper
	 * @param \phpbb\path_helper					$path_helper	phpBB path helper
	 * @param \phpbb\template\template				$template		Template object
	 * @param \phpbb\user							$user			User object
	 * @param string								$php_ext		phpEx
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\config\config $config, \phpbb\path_helper $path_helper, \phpbb\template\template $template, \phpbb\user $user, $php_ext)
	{
		global $phpbb_container;
		
		$this->container = &$phpbb_container;
		$this->db = $db;
		$this->config = $config;
		$this->path_helper = $path_helper;
		$this->template = $template;
		$this->user = $user;
		$this->php_ext = $php_ext;
		
		$this->ext_root_path = 'ext/wolfsblvt/avatarsonmemberlist';
		
		// Add language vars
		$this->user->add_lang_ext('wolfsblvt/avatarsonmemberlist', 'avatarsonmemberlist');
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header'				=> 'assign_template_vars',
		);
	}
	
	/**
	 * Assigns template vars
	 * 
	 * @param object $event The event object
	 * @return void
	 */
	public function assign_template_vars()
	{
		$this->template->assign_vars(array(
			'T_EXT_AVATARSONMEMBERLIST_PATH'			=> $this->path_helper->get_web_root_path() . $this->ext_root_path,
			'T_EXT_AVATARSONMEMBERLIST_THEME_PATH'		=> $this->path_helper->get_web_root_path() . $this->ext_root_path . '/styles/' . $this->user->style['style_path'] . '/theme',
		));
	}
}
