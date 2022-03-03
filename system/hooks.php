<?php

/**
 * Events system
 *
 * @package   MyAAC
 * @author    Slawkens <slawkens@gmail.com>
 * @copyright 2019 MyAAC
 * @link      https://my-aac.org
 */
defined('MYAAC') or die('Direct access not allowed!');

const HOOK_STARTUP = 1;
const HOOK_BEFORE_PAGE = 2;
const HOOK_AFTER_PAGE = 3;
const HOOK_FINISH = 4;
const HOOK_TIBIACOM_ARTICLE = 5;
const HOOK_TIBIACOM_BORDER_3 = 6;
const HOOK_CHARACTERS_BEFORE_INFORMATIONS = 7;
const HOOK_CHARACTERS_AFTER_INFORMATIONS = 8;
const HOOK_CHARACTERS_BEFORE_SIGNATURE = 9;
const HOOK_CHARACTERS_AFTER_SIGNATURE = 10;
const HOOK_CHARACTERS_AFTER_ACCOUNT = 11;
const HOOK_CHARACTERS_AFTER_CHARACTERS = 12;
const HOOK_LOGIN = 13;
const HOOK_LOGIN_ATTEMPT = 14;
const HOOK_LOGOUT = 15;
const HOOK_ACCOUNT_CREATE_BEFORE_FORM = 16;
const HOOK_ACCOUNT_CREATE_BEFORE_BOXES = 17;
const HOOK_ACCOUNT_CREATE_BETWEEN_BOXES_1 = 18;
const HOOK_ACCOUNT_CREATE_BETWEEN_BOXES_2 = 19;
const HOOK_ACCOUNT_CREATE_AFTER_BOXES = 20;
const HOOK_ACCOUNT_CREATE_BEFORE_ACCOUNT = 21;
const HOOK_ACCOUNT_CREATE_AFTER_ACCOUNT = 22;
const HOOK_ACCOUNT_CREATE_AFTER_EMAIL = 23;
const HOOK_ACCOUNT_CREATE_AFTER_COUNTRY = 24;
const HOOK_ACCOUNT_CREATE_AFTER_PASSWORDS = 25;
const HOOK_ACCOUNT_CREATE_AFTER_RECAPTCHA = 26;
const HOOK_ACCOUNT_CREATE_BEFORE_CHARACTER_NAME = 27;
const HOOK_ACCOUNT_CREATE_AFTER_CHARACTER_NAME = 28;
const HOOK_ACCOUNT_CREATE_AFTER_SEX = 29;
const HOOK_ACCOUNT_CREATE_AFTER_VOCATION = 30;
const HOOK_ACCOUNT_CREATE_AFTER_TOWNS = 31;
const HOOK_ACCOUNT_CREATE_BEFORE_SUBMIT_BUTTON = 32;
const HOOK_ACCOUNT_CREATE_AFTER_FORM = 33;
const HOOK_ACCOUNT_CREATE_AFTER_SUBMIT = 34;
const HOOK_FIRST = HOOK_STARTUP;
const HOOK_LAST = HOOK_ACCOUNT_CREATE_AFTER_SUBMIT;

require_once LIBS . 'plugins.php';

class Hook
{
    private $_name, $_type, $_file;
    
    public function __construct($name, $type, $file)
    {
        $this->_name = $name;
        $this->_type = $type;
        $this->_file = $file;
    }
    
    public function execute($params)
    {
        extract($params);
        /*if(is_callable($this->_callback))
        {
            $tmp = $this->_callback;
            $ret = $tmp($params);
        }*/
        
        global $db, $config, $template_path, $ots, $content, $twig;
        if (file_exists(BASE . $this->_file)) {
            $ret = require BASE . $this->_file;
        }
        
        return !isset($ret) || $ret == 1 || $ret;
    }
    
    public function name() { return $this->_name; }
    
    public function type() { return $this->_type; }
}

class Hooks
{
    private static $_hooks = array();
    
    public function register($hook, $type = '', $file = null)
    {
        if (!($hook instanceof Hook)) {
            $hook = new Hook($hook, $type, $file);
        }
        
        self::$_hooks[$hook->type()][] = $hook;
    }
    
    public function trigger($type, $params = array())
    {
        $ret = true;
        if (isset(self::$_hooks[$type])) {
            foreach (self::$_hooks[$type] as $name => $hook) {
                /** @var $hook Hook */
                if (!$hook->execute($params)) {
                    $ret = false;
                }
            }
        }
        
        return $ret;
    }
    
    public function exist($type)
    {
        return isset(self::$_hooks[$type]);
    }
    
    public function load()
    {
        foreach (Plugins::getHooks() as $hook) {
            $this->register($hook['name'], $hook['type'], $hook['file']);
        }
    }
}
