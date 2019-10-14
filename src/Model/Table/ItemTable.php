<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Item Model
 *
 * @method \App\Model\Entity\Item get($primaryKey, $options = [])
 * @method \App\Model\Entity\Item newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Item[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Item|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Item[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Item findOrCreate($search, callable $callback = null, $options = [])
 */
class ItemTable extends Table
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

        $this->setTable('item');
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
            ->allowEmptyString('ITEM_ID')
            ->add('ITEM_ID', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer('PERM_LOCATION')
            ->allowEmptyString('PERM_LOCATION');

        $validator
            ->integer('TEMP_LOCATION')
            ->allowEmptyString('TEMP_LOCATION');

        $validator
            ->integer('ITEM_TYPE_ID')
            ->allowEmptyString('ITEM_TYPE_ID');

        $validator
            ->integer('TEMP_ITEM_TYPE_ID')
            ->allowEmptyString('TEMP_ITEM_TYPE_ID');

        $validator
            ->integer('COPY_NUMBER')
            ->allowEmptyString('COPY_NUMBER');

        $validator
            ->scalar('ON_RESERVE')
            ->maxLength('ON_RESERVE', 1)
            ->allowEmptyString('ON_RESERVE');

        $validator
            ->integer('RESERVE_CHARGES')
            ->allowEmptyString('RESERVE_CHARGES');

        $validator
            ->integer('PIECES')
            ->allowEmptyString('PIECES');

        $validator
            ->integer('PRICE')
            ->allowEmptyString('PRICE');

        $validator
            ->scalar('SPINE_LABEL')
            ->maxLength('SPINE_LABEL', 25)
            ->allowEmptyString('SPINE_LABEL');

        $validator
            ->integer('HISTORICAL_CHARGES')
            ->allowEmptyString('HISTORICAL_CHARGES');

        $validator
            ->integer('HISTORICAL_BROWSES')
            ->allowEmptyString('HISTORICAL_BROWSES');

        $validator
            ->integer('RECALLS_PLACED')
            ->allowEmptyString('RECALLS_PLACED');

        $validator
            ->integer('HOLDS_PLACED')
            ->allowEmptyString('HOLDS_PLACED');

        $validator
            ->dateTime('CREATE_DATE')
            ->allowEmptyDateTime('CREATE_DATE');

        $validator
            ->dateTime('MODIFY_DATE')
            ->allowEmptyDateTime('MODIFY_DATE');

        $validator
            ->scalar('CREATE_OPERATOR_ID')
            ->maxLength('CREATE_OPERATOR_ID', 10)
            ->allowEmptyString('CREATE_OPERATOR_ID');

        $validator
            ->scalar('MODIFY_OPERATOR_ID')
            ->maxLength('MODIFY_OPERATOR_ID', 10)
            ->allowEmptyString('MODIFY_OPERATOR_ID');

        $validator
            ->integer('CREATE_LOCATION_ID')
            ->allowEmptyString('CREATE_LOCATION_ID');

        $validator
            ->integer('MODIFY_LOCATION_ID')
            ->allowEmptyString('MODIFY_LOCATION_ID');

        $validator
            ->integer('ITEM_SEQUENCE_NUMBER')
            ->allowEmptyString('ITEM_SEQUENCE_NUMBER');

        $validator
            ->integer('HISTORICAL_BOOKINGS')
            ->allowEmptyString('HISTORICAL_BOOKINGS');

        $validator
            ->integer('MEDIA_TYPE_ID')
            ->allowEmptyString('MEDIA_TYPE_ID');

        $validator
            ->integer('SHORT_LOAN_CHARGES')
            ->allowEmptyString('SHORT_LOAN_CHARGES');

        $validator
            ->scalar('MAGNETIC_MEDIA')
            ->maxLength('MAGNETIC_MEDIA', 1)
            ->allowEmptyString('MAGNETIC_MEDIA');

        $validator
            ->scalar('SENSITIZE')
            ->maxLength('SENSITIZE', 1)
            ->allowEmptyString('SENSITIZE');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['ITEM_ID']));

        return $rules;
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
