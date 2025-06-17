<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $name
 * @property int $year
 * @property string|null $description
 * @property string $isbn
 * @property string|null $main_photo
 */
class Book extends \yii\db\ActiveRecord
{

    public  $authorIds = [];

    public $mainImage;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'main_photo'], 'default', 'value' => null],
            [['name', 'year', 'isbn'], 'required'],
            ['isbn', 'unique', 'targetClass' => static::class],
            [['year'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 13],
            [['authorIds'], 'each', 'rule' => ['integer']],
            [['mainImage'], 'file', 'skipOnEmpty' => !$this->isNewRecord, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'year' => 'Year',
            'description' => 'Description',
            'isbn' => 'Isbn',
            'main_photo' => 'Main Photo',
            'authorIds' => 'Авторы',
        ];
    }

    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('authors_books', ['book_id' => 'id']);
    }

    public function getImageUrl():? string
    {
        if (empty($this->main_photo)) {
            return null;
        }

        return Yii::getAlias(Yii::$app->params['uploadsUrl']) . $this->main_photo;
    }
}
