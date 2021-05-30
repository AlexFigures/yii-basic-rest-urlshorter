<?php

namespace app\modules\api\v1\models;



use yii\base\Model;
use yii\db\ActiveRecord;
use app\commands\GenerateShortLink;

use Yii;

/**
 * This is the model class for table "short_url".
 *
 * @property int $id
 * @property string $full_url
 * @property string|null $short_hash
 * @property string $date_create
 * @property int $counter
 */
class Link extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'short_url';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_url'], 'required'],
            [['date_create'], 'safe'],
            [['counter'], 'integer'],
            [['full_url'], 'string', 'max' => 255],
            [['short_hash'], 'string', 'max' => 8],
            [['full_url'], 'unique'],
            [['short_hash'], 'unique'],
            ['full_url', 'validateFull_url'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_url' => 'Full Url',
            'short_hash' => 'Short Hash',
            'date_create' => 'Date Create',
            'counter' => 'Counter',
        ];
    }

    public function validateFull_url($full_url)
    {
        $channel = curl_init();
        curl_setopt($channel, CURLOPT_URL, $full_url);
        curl_setopt($channel, CURLOPT_NOBODY, true);
        curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
        curl_exec($channel);
        $response = curl_getinfo($channel, CURLINFO_HTTP_CODE);
        curl_close($channel);

        return (!empty($response) && $response !== 404);
    }

}