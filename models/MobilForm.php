<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use Yii;
use yii\base\Model;

class MobilForm extends Model {

    public $verifyCode;
    public $otr;
    public $tahun;
    public $tenor;
    public $jumlah;
    public $angsuran;
    public $hasil;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
                [['otr', 'tahun', 'tenor', 'jumlah'], 'required'],
                [['otr', 'tahun', 'tenor', 'jumlah'], 'number'],
                [['verifyCode'], 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'captcha' => 'Verification Code',
            'otr' => 'Harga Kendaraan OTR *',
            'tahun' => 'Tahun Kendaraan *',
            'tenor' => 'Tenor *',
            'jumlah' => 'Jumlah Pinjaman *',
        ];
    }

}
