<?php

namespace app\modules\auth\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\base\models\User;

/**
 * UserSearch represents the model behind the search form about `app\modules\base\models\User`.
 */
class UserSearch extends User
{
    public $role;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_User'], 'integer'],
            [['login', 'email', 'ip_address', 'role'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function setRole($value) {
        $this->role = $value;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_User' => $this->id_User,
            'item_name' => $this->role,
        ]);

        $query->andFilterWhere(['like', 'login', $this->login])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'ip_address', $this->ip_address]);

        $query->leftJoin('auth_assignment', 'user_id = id_User');

        return $dataProvider;
    }
}
