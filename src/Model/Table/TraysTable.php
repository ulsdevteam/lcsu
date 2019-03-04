<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Trays Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Trays
 *
 * @method \App\Model\Entity\Tray get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tray newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Tray[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tray|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tray|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tray patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tray[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tray findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TraysTable extends Table
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

        $this->setTable('trays');
        $this->setDisplayField('tray_id');
        $this->setPrimaryKey('tray_id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Books', [
            'foreignKey' => 'tray_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Traysizes', [
            'foreignKey' => 'traysize_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Shelves', [
            'foreignKey' => 'shelf_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Status', [
            'foreignKey' => 'status_id',
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
            ->scalar('tray_barcode')
            ->allowEmpty('tray_barcode');
            // ->add('tray_barcode', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('modified_user')
            ->notEmpty('modified_user');

        $validator
            ->integer('shelf_id')
            ->allowEmpty('shelf_id');

        $validator
            ->scalar('tray_title')
            ->notEmpty('tray_title');

        $validator->add('tray_title', 'custom', [
            'rule' => function ($value) {
                $regex = '/T[0-9]{2}/';
                if (preg_match($regex, $value)) {
                    $exisiting = $this->find()->where(['tray_title' => $value])->first();
                    if (!isset($exisiting)) return true;
                }
                return false;
            },
            'message' => 'This range title may exist in database, or the format is incorrect. (e.g. R01)'
        ]);
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
        $rules->add($rules->isUnique(['tray_barcode']));
        // $rules->add($rules->existsIn(['tray_barcode'], 'Trays'));

        return $rules;
    }
}
