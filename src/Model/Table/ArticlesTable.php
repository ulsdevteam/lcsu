<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Articles Model
 *
 * @method \App\Model\Entity\Article get($primaryKey, $options = [])
 * @method \App\Model\Entity\Article newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Article[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Article|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Article|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Article patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Article[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Article findOrCreate($search, callable $callback = null, $options = [])
 */
class ArticlesTable extends Table
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

        $this->setTable('articles');
        $this->setDisplayField('article_id');
        $this->setPrimaryKey('article_id');
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
            ->integer('article_id')
            ->allowEmpty('article_id', 'create');

        $validator
            ->scalar('article_name')
            ->maxLength('article_name', 45)
            ->requirePresence('article_name', 'create')
            ->notEmpty('article_name');

        $validator
            ->scalar('article_category')
            ->maxLength('article_category', 45)
            ->requirePresence('article_category', 'create')
            ->notEmpty('article_category');

        $validator
            ->scalar('article_content')
            ->maxLength('article_content', 45)
            ->requirePresence('article_content', 'create')
            ->notEmpty('article_content');

        $validator
            ->scalar('article_author')
            ->maxLength('article_author', 45)
            ->requirePresence('article_author', 'create')
            ->notEmpty('article_author');

        $validator
            ->dateTime('timestamp')
            ->requirePresence('timestamp', 'create')
            ->notEmpty('timestamp');

        return $validator;
    }
}
