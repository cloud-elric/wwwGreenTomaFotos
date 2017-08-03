<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_usuarios".
 *
 * @property string $id_usuario
 * @property string $txt_nombre_completo
 * @property string $txt_telefono_celular
 * @property string $txt_token
 * @property string $txt_email
 * @property string $fch_registro
 * @property string $b_aceptar_terminos
 */
class EntUsuarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre_completo', 'txt_telefono_celular', 'txt_token', 'txt_email'], 'required', 'message'=>'Campos requeridos'],
            [['fch_registro'], 'safe'],
            [['b_aceptar_terminos'], 'integer'],
            [['txt_nombre_completo'], 'string', 'max' => 150],
            [['txt_telefono_celular'], 'string', 'max' => 10],
            [['txt_token'], 'string', 'max' => 70],
            [['txt_email'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => 'Id Usuario',
            'txt_nombre_completo' => 'Nombre completo',
            'txt_telefono_celular' => 'Télefono celular',
            'txt_token' => 'Txt Token',
            'txt_email' => 'Email',
            'fch_registro' => 'Fch Registro',
            'b_aceptar_terminos' => 'B Aceptar Terminos',
        ];
    }
}
