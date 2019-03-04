<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Traysizes Model
 *
 * @method \App\Model\Entity\Traysize get($primaryKey, $options = [])
 * @method \App\Model\Entity\Traysize newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Traysize[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Traysize|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Traysize|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Traysize patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Traysize[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Traysize findOrCreate($search, callable $callback = null, $options = [])
 */
class TraysizesTable extends Table
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

        $this->setTable('traysizes');
        $this->setDisplayField('traysize_id');
        $this->setPrimaryKey('traysize_id');

        $this->hasMany('trays', [
            'foreignKey' => 'traysize_id',
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
            ->integer('traysize_id')
            ->allowEmpty('traysize_id', 'create');

        $validator
            ->scalar('tray_category')
            ->maxLength('tray_category', 1)
            ->requirePresence('tray_category', 'create')
            ->notEmpty('tray_category');

        $validator
            ->integer('shelf_height')
            ->requirePresence('shelf_height', 'create')
            ->notEmpty('shelf_height');

        $validator
            ->integer('num_trays')
            ->requirePresence('num_trays', 'create')
            ->notEmpty('num_trays');

        return $validator;
    }
}
