<?php
namespace xz1mefx\multilang\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%source_message}}".
 *
 * @property integer   $id
 * @property string    $category
 * @property string    $message
 * @property array     $langListArray
 *
 * @property Message[] $messages
 */
class SourceMessage extends ActiveRecord
{

    const TABLE_NAME = '{{%ml_source_message}}';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    /**
     * Return all categories array
     * @return array
     */
    public static function getAllCategoriesArray()
    {
        $cacheKey = [__CLASS__, 'allCategoriesArray'];
        if (Yii::$app->multilangCache->exists($cacheKey)) {
            return Yii::$app->multilangCache->get($cacheKey);
        }
        $res = ArrayHelper::getColumn(self::find()->select('category')->groupBy('category')->all(), 'category');
        Yii::$app->multilangCache->set($cacheKey, $res);
        return $res;
    }

    /**
     * Clear model multilangCache
     */
    public static function clearCache()
    {
        return Yii::$app->multilangCache->delete([__CLASS__, 'allCategoriesArray']);
    }

    /**
     * @return array
     */
    public static function getCategoriesDrDownList()
    {
        return ArrayHelper::map(self::find()->all(), 'category', 'category');
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => time(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['message'], 'required'],
            [['message'], 'string'],
            [['category'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        Yii::$app->multilangCache->flush();
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        Yii::$app->multilangCache->flush();
        parent::afterDelete();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('multilang-tools', 'ID'),
            'category' => Yii::t('multilang-tools', 'Message category'),
            'message' => Yii::t('multilang-tools', 'Message key'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['id' => 'id']);
    }

    /**
     * @param $local string
     *
     * @return string
     */
    public function getTranslationByLocal($local)
    {
        $model = Message::findOne(['id' => $this->id, 'language' => $local]);
        if ($model) {
            return $model->translation;
        }
        return '';
    }

}
