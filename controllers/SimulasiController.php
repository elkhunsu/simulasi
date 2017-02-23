<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;

/**
 * Description of SimulasiController
 *
 * @author elkinpk
 */
class SimulasiController extends \yii\base\Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionHitung() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if (isset($data)) {

                $harga = (int) $data['harga'] ? (int) $data['harga'] : 0;
                $tahun = (int) $data['tahun'] ? (int) $data['tahun'] : 0;
                $tenor = (int) $data['tenor'] ? (int) $data['tenor'] : 0;
                $funding = (int) $data['funding'] ? (int) $data['funding'] : 0;
                /*
                 * admin biaya
                 */
                $asuransiJiwa = $this->asuransiJiwa($harga, $tenor);
                $asuransiKend = $this->asuransiMobil($tenor);
                $provisi = $funding * (2.25 / 100 );
                $fidusia = $this->fidusia($funding);
                $biayaAdmin = $this->biayaAdmin($funding);
                $totalAdmin = $provisi + $fidusia + $biayaAdmin;

                /*
                 * ntf
                 */
                $ntf = $asuransiJiwa + $asuransiKend + $totalAdmin + $funding;

                /*
                 * angsuran
                 */
                $pmt = $this->PMT(21 / 1200, $tenor, -$ntf);
                $result = round($pmt, -2);
                return [
                    'fidusia' => $fidusia,
                    'provisi' => $provisi,
                    'biayaAdmin' => $biayaAdmin,
                    'asuransiKend' => $asuransiKend,
                    'asuransiJiwa' => $asuransiJiwa,
                    'totalAdmin' => $totalAdmin,
                    'ntf' => $ntf,
                    'data' => $result,
                ];
            }
        } else {
            return false;
        }
    }

    private function PMT($i, $n, $p) {
        return $i * $p * pow((1 + $i), $n) / (1 - pow((1 + $i), $n));
    }

    private function biayaAdmin($funding) {
        if ($funding <= 75000000) {
            return 750000;
        } else if ($funding < 75000000 && $funding <= 150000000) {
            return 1000000;
        } else if ($funding > 150000000) {
            return 1250000;
        }
    }

    private function fidusia($funding) {
        if ($funding <= 50000000) {
            return 175000;
        } else if ($funding > 50000000 && $funding <= 100000000) {
            return 250000;
        } else if ($funding > 100000000 && $funding <= 250000000) {
            return 400000;
        } else if ($funding > 250000000 && $funding <= 500000000) {
            return 575000;
        } else if ($funding > 500000000 && $funding <= 1000000000) {
            return 1025000;
        }
    }

    private function asuransiJiwa($harga, $tenor) {
        if (isset($harga) && isset($tenor)) {
            $array = [
                '0.15' => 12,
                '0.33' => 24,
                '0.535' => 36,
                '0.755' => 48,
            ];
            $pengali = array_search($tenor, $array);
            $hasil = $harga * (floatval($pengali) / 100);
            return $hasil;
        } else {
            return false;
        }
    }

    private function asuransiMobil($tenor) {
        if (isset($tenor)) {
            $array = [
                750000 => 12,
                1352500 => 24,
                1857500 => 36,
                2362500 => 48,
            ];
            $cekHarga = array_search($tenor, $array);
            return $cekHarga;
        } else {
            return false;
        }
    }

}
