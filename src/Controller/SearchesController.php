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

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class SearchesController  extends AppController
{
    public function index() {
        $keyword = $this->request->getData('keyword');
        if(!isset($keyword)) $keyword = $this->request->getQuery('keyword');
        if (is_numeric($keyword)) {
            $results = TableRegistry::get('Books')->find()
                ->where(function ($exp, $q) use ($keyword) {
                    return $exp->like('book_barcode', '%'.$keyword.'%');
                });
        } else {
            $results = TableRegistry::get('Trays')->find()
                ->where(function ($exp, $q) use ($keyword) {
                    return $exp->like('tray_barcode', '%'.$keyword.'%');
                });
        }
        
        $results = $this->paginate($results);
        $this->set(compact('results', 'keyword'));
    }
}
