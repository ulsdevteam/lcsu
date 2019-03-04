<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ranges Model
 *
 * @method \App\Model\Entity\Range get($primaryKey, $options = [])
 * @method \App\Model\Entity\Range newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Range[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Range|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Range|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Range patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Range[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Range findOrCreate($search, callable $callback = null, $options = [])
 */
class RangesTable extends Table
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

        $this->setTable('ranges');
        $this->setDisplayField('range_id');
        $this->setPrimaryKey('range_id');

        $this->hasMany('Modules', [
            'foreignKey' => 'range_id',
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
            ->integer('range_id')
            ->allowEmpty('range_id', 'create');

        $validator
            ->scalar('range_title')
            ->maxLength('range_title', 3)
            ->allowEmpty('range_title');

        $validator->add('range_title', 'custom', [
            'rule' => function ($value) {
                $regex = '/R[0-9]{2}/';
                if (preg_match($regex, $value)) {
                    $exisiting = $this->find()->where(['range_title' => $value])->first();
                    if (!isset($exisiting)) return true;
                }
                return false;
            },
            'message' => 'This range title may exist in database, or the format is incorrect. (e.g. R01)'
        ]);
        return $validator;
    }
}
