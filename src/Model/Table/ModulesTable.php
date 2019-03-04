<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Modules Model
 *
 * @method \App\Model\Entity\Module get($primaryKey, $options = [])
 * @method \App\Model\Entity\Module newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Module[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Module|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Module|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Module patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Module[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Module findOrCreate($search, callable $callback = null, $options = [])
 */
class ModulesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('modules');
        $this->setDisplayField('module_id');
        $this->setPrimaryKey('module_id');

        $this->belongsTo('Ranges', [
            'foreignKey' => 'range_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Shelves', [
            'foreignKey' => 'module_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('module_id')
            ->allowEmpty('module_id', 'create');

        $validator
            ->scalar('module_title')
            ->maxLength('module_title', 3)
            ->allowEmpty('module_title');

        $validator->add('module_title', 'custom', [
            'rule' => function ($value, $content) {
                $regex = '/M[0-9]{2}/';
                if (preg_match($regex, $value)) {
                    $exisiting = $this->find()->where(['module_title' => $value, 'range_id' => $content['data']['range_id']])->first();
                    if (!isset($exisiting)) return true;
                }
                return false;
            },
            'message' => 'This module title may exist in database, or the format is incorrect. (e.g. M01)'
        ]);

        return $validator;
    }
}
