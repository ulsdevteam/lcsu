<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Location Model
 *
 * @property \App\Model\Table\LEDGERTable|\Cake\ORM\Association\BelongsToMany $LEDGER
 * @property \App\Model\Table\REQUESTGROUPTable|\Cake\ORM\Association\BelongsToMany $REQUESTGROUP
 * @property \App\Model\Table\SORTGROUPTable|\Cake\ORM\Association\BelongsToMany $SORTGROUP
 *
 * @method \App\Model\Entity\Location get($primaryKey, $options = [])
 * @method \App\Model\Entity\Location newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Location[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Location|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Location saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Location patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Location[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Location findOrCreate($search, callable $callback = null, $options = [])
 */
class LocationTable extends Table
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

        $this->setTable('LOCATION'); //LOCATION_ID
        $this->setAlias('L');
        $this->setPrimaryKey('LOCATION_ID');
        
        $this->hasMany('Item', [
            'foreignKey' => 'LOCATION_ID',
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
            ->integer('LOCATION_ID')
            ->allowEmptyString('LOCATION_ID')
            ->add('LOCATION_ID', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('LOCATION_CODE')
            ->maxLength('LOCATION_CODE', 10)
            ->allowEmptyString('LOCATION_CODE');

        $validator
            ->scalar('LOCATION_NAME')
            ->maxLength('LOCATION_NAME', 25)
            ->allowEmptyString('LOCATION_NAME');

        $validator
            ->scalar('LOCATION_DISPLAY_NAME')
            ->maxLength('LOCATION_DISPLAY_NAME', 60)
            ->allowEmptyString('LOCATION_DISPLAY_NAME');

        $validator
            ->scalar('LOCATION_SPINE_LABEL')
            ->maxLength('LOCATION_SPINE_LABEL', 25)
            ->allowEmptyString('LOCATION_SPINE_LABEL');

        $validator
            ->scalar('LOCATION_OPAC')
            ->maxLength('LOCATION_OPAC', 1)
            ->allowEmptyString('LOCATION_OPAC');

        $validator
            ->scalar('SUPPRESS_IN_OPAC')
            ->maxLength('SUPPRESS_IN_OPAC', 1)
            ->allowEmptyString('SUPPRESS_IN_OPAC');

        $validator
            ->integer('LIBRARY_ID')
            ->allowEmptyString('LIBRARY_ID');

        $validator
            ->integer('MFHD_COUNT')
            ->allowEmptyString('MFHD_COUNT');

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
        $rules->add($rules->isUnique(['LOCATION_ID']));

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
