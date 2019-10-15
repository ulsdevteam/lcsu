<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemStatusType Model
 *
 * @method \App\Model\Entity\ItemStatusType get($primaryKey, $options = [])
 * @method \App\Model\Entity\ItemStatusType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ItemStatusType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemStatusType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemStatusType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemStatusType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ItemStatusType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemStatusType findOrCreate($search, callable $callback = null, $options = [])
 */
class ItemStatusTypeTable extends Table
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

        $this->setTable('ITEM_STATUS_TYPE');
        $this->setAlias('IST');
        $this->setDisplayField('ITEM_STATUS_DESC');
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
            ->integer('ITEM_STATUS_TYPE')
            ->allowEmptyString('ITEM_STATUS_TYPE', 'create');

        $validator
            ->scalar('ITEM_STATUS_DESC')
            ->maxLength('ITEM_STATUS_DESC', 25)
            ->allowEmptyString('ITEM_STATUS_DESC', 'create');

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
