<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;
use App\Auth\EnvAuthenticate;
use Cake\Core\Configure;
use Cake\Http\BaseApplication;
use ContactManager\Plugin as ContactManagerPlugin;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        $this->loadComponent('Security');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Env' => [
                    'fields' => ['username' => 'username']
                ],
            ],
            'authorize' => 'Controller',
            'storage' => 'Memory'
        ]);
    }

    public function bootstrap()
    {
        parent::bootstrap();
        // Load the contact manager plugin by class name
        $this->addPlugin(ContactManagerPlugin::class);

        // Load a plugin with a vendor namespace by 'short name'
        $this->addPlugin('CakeDC/OracleDriver', ['bootstrap' => true]);
    }

    public function isAuthorized($user)
    {
        if ($user == NULL)
            $this->blockInvalidUser();
        $this->set('cur_user', $user);
        $currentAction = $this->request->getParam('action');
        $currentController = $this->request->getParam('controller');
        switch ($user['permission_id']) {
            case Configure::read('Managers'):
                break;
            case Configure::read('Scanners'):
                $allow = ['Trays', 'Books'];
                if ($currentAction === 'add' || $currentAction === 'edit' || $currentAction === 'delete' || !in_array($currentController, $allow)) {
                    $this->actionNotAllow();
                }
                break;
            default:
                $this->blockInvalidUser();
                break;
        }

        return true;
    }

    public function blockInvalidUser()
    {
        $this->redirect(['controller' => 'error', 'action' => 'invalid_user']);
    }

    public function actionNotAllow()
    {
        $this->Flash->error(__('You are not allow to access this location.'));
        $this->redirect(['controllrt' => 'trays', 'action' => 'index']);
    }

}
