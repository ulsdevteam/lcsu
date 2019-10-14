<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemStatus Model
 *
 * @method \App\Model\Entity\ItemStatus get($primaryKey, $options = [])
 * @method \App\Model\Entity\ItemStatus newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ItemStatus[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemStatus|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemStatus saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ItemStatus[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemStatus findOrCreate($search, callable $callback = null, $options = [])
 */
class ItemStatusTable extends Table
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

        $this->setTable('item_status');
        
        $this->belongsTo('Item', [
            'foreignKey' => 'ITEM_ID',
            'joinType' => 'INNER',
            'joinTable' => 'ITEM'
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
            ->integer('ITEM_ID')
            ->allowEmptyString('ITEM_ID');

        $validator
            ->integer('ITEM_STATUS')
            ->allowEmptyString('ITEM_STATUS');

        $validator
            ->dateTime('ITEM_STATUS_DATE')
            ->allowEmptyDateTime('ITEM_STATUS_DATE');

        $validator
            ->scalar('ITEM_STATUS_OPERATOR')
            ->maxLength('ITEM_STATUS_OPERATOR', 10)
            ->allowEmptyString('ITEM_STATUS_OPERATOR');

        return $validator;
    }

    /**
     * Returns the database connection name to use by default.
     *
     * @return string
     */
    public static function defaultConnectionName()
    {
        return 'voyager';
    }
}
