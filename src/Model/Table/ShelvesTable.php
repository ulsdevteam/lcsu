<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;

/**
 * Shelves Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Traysizes
 *
 * @method \App\Model\Entity\Shelf get($primaryKey, $options = [])
 * @method \App\Model\Entity\Shelf newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Shelf[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Shelf|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Shelf|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Shelf patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Shelf[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Shelf findOrCreate($search, callable $callback = null, $options = [])
 */
class ShelvesTable extends Table
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

        $this->setTable('shelves');
        $this->setDisplayField('shelf_id');
        $this->setPrimaryKey('shelf_id');

        $this->belongsTo('Traysizes', [
            'foreignKey' => 'traysize_id'
        ]);

        $this->belongsTo('Modules', [
            'foreignKey' => 'module_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('trays', [
            'foreignKey' => 'shelf_id',
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
            ->integer('shelf_id')
            ->allowEmpty('shelf_id', 'create');

        $validator
            ->scalar('shelf_barcode')
            ->maxLength('shelf_barcode', 45)
            ->allowEmpty('shelf_barcode');

        $validator
            ->integer('shelf_height')
            ->range('shelf_height',[0, 50])
            ->notEmpty('shelf_height');

        $validator
            ->scalar('tray_category')
            ->maxLength('tray_category', 1)
            ->allowEmpty('tray_category');
        
        $validator
            ->integer('traysize_id')
            ->allowEmpty('traysize_id');
        
        $validator
            ->scalar('shelf_title')
            ->maxLength('shelf_title', 3)
            ->notEmpty('shelf_title');

        $validator->add('shelf_title', 'custom', [
            'rule' => function ($value) {
                $regex = '/S[0-9]{2}/';
                if (preg_match($regex, $value)) {
                    $exisiting = $this->find()->where(['shelf_barcode' => $value])->first();
                    if (!isset($exisiting)) return true;
                }
                return false;
            },
            'message' => 'This shelf title may exist in database, or the format is incorrect. (e.g. S01)'
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
        $rules->add($rules->existsIn(['traysize_id'], 'Traysizes'));
        $rules->add($rules->isUnique(['shelf_barcode']));

        return $rules;
    }
}
