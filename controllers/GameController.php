<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use app\models\Game;
use app\components\AffJetApi;

class GameController extends Controller {

    public function actionPlay($id) {
        $query = Yii::$app->db->createCommand('select game_id, '
                        . 'game_name, '
                        . 'game_instruction, '
                        . 'game_description, '
                        . 'game_dimension_width, '
                        . 'game_dimension_height, '
                        . 'game_technology '
                        . 'from games where game_id = :id')
                ->bindValue(':id', $id)
                ->queryOne();

        if ($query == NULL) {
            return $this->render('error', [
                        'name' => "404 not found",
                        'message' => "404 PAGE NOT FOUND",
            ]);
        }

        $game = new Game();
        $game->game_id = $query['game_id'];
        $game->game_name = $query['game_name'];
        $game->game_instruction = $query['game_instruction'];
        $game->game_description = $query['game_description'];
        $game->game_dimension_width = $query['game_dimension_width'];
        $game->game_dimension_height = $query['game_dimension_height'];
        $game->game_technology = $query['game_technology'];

        $installerUrl = $this->getInstallerDownloadUrl($game, true);
        $installerUrl['INSTALLER_CODE'] = urldecode($installerUrl['INSTALLER_CODE']);
        $installerUrl['INSTALLER_HEAD_CODE'] = urldecode($installerUrl['INSTALLER_HEAD_CODE']);
        return $this->render('game', [
            'game' => $game,
            'installerUrl' => $installerUrl
        ]);
    }

    public static function getInstallerDownloadUrl($game, $setDefaultTicket = false, $sid = false) {
        $ajUrlId = 1; //default

        $url = false;
        // data collection
        $info['affiliateUrlId'] = $ajUrlId;    // $_GET['a'];
        $info['subAffiliateUrlId'] = 'lp-dwl';   //  $_GET['aid'];
        $info['landingPageId'] = 1;         //   $_GET['lp'];

        $requestId = base64_encode("{$info['affiliateUrlId']}-{$info['landingPageId']}-{$info['subAffiliateUrlId']}");
        // getting Installer Download Url with Tracking Pixel from API
        $serverResponse = AffJetApi::getInstallerCode($info['affiliateUrlId'], $requestId, $info['landingPageId'], $setDefaultTicket, $sid);
        $tmpUrl = '';
        $url_requirements = 'http://' . "arcadesauce" . '.com/requirements';
        $url = $serverResponse[AffJetApi::RESPONSE_STATUS_PARAM_INSTALLER_URL];

        //user has instaler - redirect them to gamePlay page
        if (AffJetApi::userHasInstaller() && $game != NULL) {
            $gameUrl = str_replace('.comPlay_', '.com/Play_', Yii::$app->createAbsoluteUrl("/site/game", array('id' => $game['game_id'])));
            //header( 'Location: '.  $gameUrl) ;
            return false;
        }
        //redirect to requirements page
        else if ($serverResponse[AffJetApi::RESPONSE_STATUS_PARAM_STATUS] != AffJetApi::STATUS_OK) {
            header('Location: ' . $url_requirements);
        }

        return $serverResponse;
    }

}
