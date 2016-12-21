<?php
namespace xz1mefx\multilang\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%lang}}".
 *
 * @property integer $id
 * @property string $url
 * @property string $locale
 * @property string $name
 * @property integer $default
 * @property integer $created_at
 * @property integer $updated_at
 */
class Lang extends ActiveRecord
{
    const TABLE_NAME = '{{%ml_lang}}';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    /**
     * Return all languages in array
     * @return array
     */
    public static function getLangListArray()
    {
        $cacheKey = [__CLASS__, 'langListArray'];
        if (Yii::$app->multilangCache->exists($cacheKey)) {
            return Yii::$app->multilangCache->get($cacheKey);
        }
        $res = ArrayHelper::index(self::find()->asArray()->all(), 'url');
        Yii::$app->multilangCache->set($cacheKey, $res);
        return $res;
    }

    /**
     * Return all locales array
     * @return array
     */
    public static function getAllLocalesArray()
    {
        $cacheKey = [__CLASS__, 'allLocalesArray'];
        if (Yii::$app->multilangCache->exists($cacheKey)) {
            return Yii::$app->multilangCache->get($cacheKey);
        }
        $res = ArrayHelper::getColumn(self::find()->select('locale')->groupBy('locale')->all(), 'locale');
        Yii::$app->multilangCache->set($cacheKey, $res);
        return $res;
    }

    /**
     * Clear model multilangCache
     */
    public static function clearCache()
    {
        return Yii::$app->multilangCache->delete([__CLASS__, 'langListArray'])
            && Yii::$app->multilangCache->delete([__CLASS__, 'allLocalesArray'])
            && Yii::$app->multilangCache->delete([__CLASS__, 'defaultLang']);
    }

    /**
     * Get default language data
     * @return array
     */
    public static function getDefaultLang()
    {
        $cacheKey = [__CLASS__, 'defaultLang'];
        if (Yii::$app->multilangCache->exists($cacheKey)) {
            return Yii::$app->multilangCache->get($cacheKey);
        }
        $res = self::findOne(['default' => 1])->getAttributes();
        Yii::$app->multilangCache->set($cacheKey, $res);
        return $res;
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
    public function beforeValidate()
    {
        if ($this->default == 0 && isset($this->oldAttributes['default']) && $this->oldAttributes['default'] == 1) {
            Yii::$app->session->setFlash('danger', Yii::t('multilang-tools', 'You can only override the default language'));
            return false;
        }

        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'locale', 'name'], 'required'],
            [['default', 'created_at', 'updated_at'], 'integer'],
            [['url'], 'string', 'max' => 2],
            [['locale'], 'string', 'max' => 16],
            [['name'], 'string', 'max' => 255],
            [['url'], 'unique'],
            [['locale'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        Yii::$app->multilangCache->flush();

        if (
            $this->default == 1
            &&
            ($insert || isset($changedAttributes['default']) && $this->default != $changedAttributes['default'])
        ) {
            self::updateAll(['default' => 0], ['and', ['default' => 1], ['!=', 'id', $this->id]]);
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        Message::deleteAll(['language' => $this->locale]);

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
            'url' => Yii::t('multilang-tools', 'Url (ISO 639-1)'),
            'locale' => Yii::t('multilang-tools', 'Locale'),
            'name' => Yii::t('multilang-tools', 'Name'),
            'default' => Yii::t('multilang-tools', 'Is Default'),
            'created_at' => Yii::t('multilang-tools', 'Created At'),
            'updated_at' => Yii::t('multilang-tools', 'Updated At'),
        ];
    }
}
