<?php
/**
 * @filesource modules/v1/models/user.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace V1\User;

use Kotchasan\Http\Request;

/**
 * api.php/v1/user
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\Model
{
    /**
     * ตรวจสอบการ login
     * คืนค่า refreshToken
     *
     * @param Request $request
     *
     * @return array
     */
    public function login(Request $request)
    {
        if ($request->getMethod() !== 'POST') {
            // ตรวจสอบ Method เช่น POST GET PUT DELETE OPTIONS
            $result = array(
                'error' => array(
                    'code' => 405,
                    'message' => 'Method not allowed',
                ),
            );
        } else {
            // สำหรับเก็บ Error
            $error = array();
            // Username+Password
            $params = array(
                'username' => $request->post('username')->username(),
                'password' => $request->post('password')->password(),
            );
            // ตรวจสอบค่าที่ส่งมา
            if ($params['username'] === '') {
                // ไม่ได้ส่ง Username มา
                $error[] = 'Username cannot be blank';
            }
            if ($params['password'] === '') {
                // ไม่ได้ส่ง Password มา
                $error[] = 'Password cannot be blank';
            }
            if (empty($error)) {
                // ตรวจสอบการ Login
                $login_result = \Gcms\Login::checkMember($params);
                if (is_array($login_result)) {
                    // ตรวจสอบการ Login สำเร็จ
                    $result = array(
                        'code' => 0,
                        'email' => $login_result['email'],
                        'name' => $login_result['name'],
                        'displayname' => $login_result['displayname'],
                        'phone' => $login_result['phone1'],
                    );
                } else {
                    // ข้อผิดพลาดการเข้าระบบ
                    $result = array(
                        'code' => 401,
                        'message' => 'not a registered user',
                    );
                }
            } else {
                // มี error
                $result = array(
                    'code' => 400,
                    'message' => implode(', ', $error),
                );
            }
        }
        return $result;
    }
}
