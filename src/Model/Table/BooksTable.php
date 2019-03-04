<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Books Model
 *
 * @method \App\Model\Entity\Book get($primaryKey, $options = [])
 * @method \App\Model\Entity\Book newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Book[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Book|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Book|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Book patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Book[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Book findOrCreate($search, callable $callback = null, $options = [])
 */
class BooksTable extends Table
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

        $this->setTable('books');
        $this->setDisplayField('book_id');
        $this->setPrimaryKey('book_id');

        $this->belongsTo('Trays', [
            'foreignKey' => 'tray_id',
            'joinType' => 'INNER'
        ]);
        // $this->belongsTo('Trays', [
        //     'foreignKey' => false,
        //     'conditions' => ['Trays.tray_barcode = Books.tray_barcode'],
        //     'joinType' => 'INNER'
        // ]);
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
            ->integer('book_id')
            ->allowEmpty('book_id', 'create');

        $validator
            ->scalar('book_barcode')
            ->maxLength('book_barcode', 14)
            ->requirePresence('book_barcode', 'create')
            ->notEmpty('book_barcode')
            ->add('book_barcode', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator->add('book_barcode', 'custom', [
            'rule' => function ($value) {
                $prefix = '31735';
                $regex = '/[0-9]{14}/';
                if(substr($value,0,5)===$prefix && preg_match($regex, $value)) {
                    return true;
                }
                return false;
            },
            'message' => 'This book barcode is incorrect. (e.g. 31735xxxxxxxxx)'
        ]);

        $validator
            ->integer('tray_id')
            ->allowEmpty('tray_barcode');

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
        $rules->add($rules->isUnique(['book_barcode']));

        return $rules;
    }
}
