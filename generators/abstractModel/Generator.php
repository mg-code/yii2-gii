<?php

namespace mgcode\gii\generators\abstractModel;

use Yii;
use yii\gii\CodeFile;

/**
 * This generator will generate main and abstract ActiveRecord classes for the specified database table.
 * @author Maris Graudins <maris@mg-interactive.lv>
 */
class Generator extends \yii\gii\generators\model\Generator
{
    /** @var int Whether to save relations in main model */
    public $relationsInMain = 0;
    
    /** @inheritdoc */
    public function getName()
    {
        return 'Abstract Model Generator';
    }

    /** @inheritdoc */
    public function getDescription()
    {
        return 'This generator generates main and abstract ActiveRecord classes for the specified database table.';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['relationsInMain'], 'boolean'],
        ]);
    }

    /** @inheritdoc */
    public function requiredTemplates()
    {
        return ['model.php', 'abstractModel.php'];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'relationsInMain' => 'Generate relations in main model'
        ]);
    }

    /** @inheritdoc */
    public function hints()
    {
        return array_merge(parent::attributeLabels(), [
            'relationsInMain' => 'By default relations are saved in abstract model.'
        ]);
    }

    /** @inheritdoc */
    public function generate()
    {
        $files = [];
        $relations = $this->generateRelations();
        $db = $this->getDbConnection();
        foreach ($this->getTableNames() as $tableName) {
            // model :
            $modelClassName = $this->generateClassName($tableName);
            $queryClassName = ($this->generateQuery) ? $this->generateQueryClassName($modelClassName) : false;
            $tableSchema = $db->getTableSchema($tableName);
            $params = [
                'tableName' => $tableName,
                'className' => $modelClassName,
                'queryClassName' => $queryClassName,
                'tableSchema' => $tableSchema,
                'labels' => $this->generateLabels($tableSchema),
                'rules' => $this->generateRules($tableSchema),
                'relations' => isset($relations[$tableName]) ? $relations[$tableName] : [],
            ];
            $files[] = new CodeFile(
                    Yii::getAlias('@' . str_replace('\\', '/', $this->ns)) . '/' . $modelClassName . '.php', $this->render('model.php', $params)
            );
            $files[] = new CodeFile(
                    Yii::getAlias('@' . str_replace('\\', '/', $this->ns)) . '/base/' . $modelClassName . 'Base.php', $this->render('abstractModel.php', $params)
            );
            // query :
            if ($queryClassName) {
                $params['className'] = $queryClassName;
                $params['modelClassName'] = $modelClassName;
                $files[] = new CodeFile(
                        Yii::getAlias('@' . str_replace('\\', '/', $this->queryNs)) . '/' . $queryClassName . '.php', $this->render('query.php', $params)
                );
            }
        }
        return $files;
    }
}
