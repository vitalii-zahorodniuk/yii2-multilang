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
 * @property string $local
 * @property string $name
 * @property integer $default
 * @property integer $created_at
 * @property integer $updated_at
 */
class Lang extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lang}}';
    }

    /**
     * Return all languages in array
     * @return array
     */
    public static function getLangListArray()
    {
        $cacheKey = [__CLASS__, 'langListArray'];
        if (Yii::$app->cache->exists($cacheKey)) {
            return Yii::$app->cache->get($cacheKey);
        }
        $res = ArrayHelper::index(self::find()->asArray()->all(), 'url');
        Yii::$app->cache->set($cacheKey, $res);
        return $res;
    }

    /**
     * Get default language data
     * @return array
     */
    public static function getDefaultLang()
    {
        $cacheKey = [__CLASS__, 'defaultLang'];
        if (Yii::$app->cache->exists($cacheKey)) {
            return Yii::$app->cache->get($cacheKey);
        }
        $res = self::findOne(['default' => 1,])->getAttributes();
        Yii::$app->cache->set($cacheKey, $res);
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
            Yii::$app->session->setFlash('danger', Yii::t('xz1mefx-multilang', 'You can only override the default language'));
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
            [['url', 'local', 'name'], 'required'],
            [['default', 'created_at', 'updated_at'], 'integer'],
            [['url'], 'string', 'max' => 2],
            [['local'], 'string', 'max' => 16],
            [['name'], 'string', 'max' => 255],
            [['url'], 'unique'],
            [['local'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        self::clearCache();

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
     * Clear model cache
     */
    private static function clearCache()
    {
        Yii::$app->cache->delete([__CLASS__, 'langList']);
        Yii::$app->cache->delete([__CLASS__, 'defaultLang']);
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        self::clearCache();
        // TODO: need to clear messages
        // TODO: need to clear messages cache
        parent::afterDelete();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('xz1mefx-multilang', 'ID'),
            'url' => Yii::t('xz1mefx-multilang', 'Url'),
            'local' => Yii::t('xz1mefx-multilang', 'Local'),
            'name' => Yii::t('xz1mefx-multilang', 'Name'),
            'default' => Yii::t('xz1mefx-multilang', 'Default'),
            'created_at' => Yii::t('xz1mefx-multilang', 'Created At'),
            'updated_at' => Yii::t('xz1mefx-multilang', 'Updated At'),
        ];
    }
}
