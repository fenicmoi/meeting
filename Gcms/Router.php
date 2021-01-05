<?php
/**
 * @filesource Gcms/Router.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Gcms;

/**
 * Router Class สำหรับ GCMS
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Router extends \Kotchasan\Router
{
    /**
     * กฏของ Router สำหรับการแยกหน้าเว็บไซต์.
     *
     * @var array
     */
    protected $rules = array(
        // api.php/<method>
        '/(api)\.php\/([a-z]+)/i' => array('', 'action'),
        // css, js
        '/(css|js)\/(view)\/(index)/i' => array('module', '_mvc', '_dir'),
        // index.php/module/model/folder/_dir/_method
        '/^[a-z0-9]+\.php\/([a-z]+)\/(model)(\/([\/a-z0-9_]+)\/([a-z]+))?$/i' => array('module', '_mvc', '', '_dir', '_method'),
        // news
        '/^(news)\/(.*)$/' => array('module', 'alias'),
        // <module>
        '/^([a-z]+)$/i' => array('module'),
    );
}
