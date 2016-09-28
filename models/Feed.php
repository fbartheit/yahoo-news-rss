<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feed".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $date_posted
 * @property string $rating
 * @property integer $num_views
 * @property integer $num_rates
 * @property string $link
 * @property string $image_link
 * @property integer $type_id
 *
 * @property FeedType $type
 */
class Feed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feed';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'date_posted', 'rating', 'num_views', 'num_rates', 'link', 'type_id'], 'required'],
            [['rating'], 'number'],
            [['num_views', 'num_rates', 'type_id'], 'integer'],
            [['title'], 'string', 'max' => 600],
            [['description'], 'string', 'max' => 2000],
            [['date_posted'], 'string', 'max' => 50],
            [['link', 'image_link'], 'string', 'max' => 2000],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => FeedType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'date_posted' => 'Date Posted',
            'rating' => 'Rating',
            'num_views' => 'Num Views',
            'num_rates' => 'Num Rates',
            'link' => 'Link',
            'image_link' => 'Image Link',
            'type_id' => 'Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(FeedType::className(), ['id' => 'type_id']);
    }
}
