<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\QSL\CloudSearch\Controller\Admin;

use XLite\Core\Config;
use XLite\Core\Request;
use XLite\Module\QSL\CloudSearch\Core\ServiceApiClient;


/**
 * CloudSearch dashboard loader
 */
class CloudSearchDashboardLoader extends \XLite\Controller\Admin\AAdmin
{
    /**
     * handleRequest
     *
     * @return void
     */
    public function handleRequest()
    {
        $apiClient = new ServiceApiClient();

        if (!$apiClient->getApiKey()) {
            $apiClient->register();

            Config::updateInstance();
        }

        $apiClient->requestSecretKey();

        Config::updateInstance();

        $secretKey = $apiClient->getSecretKey();

        $request = Request::getInstance();

        $params = $request->section ? ['section' => $request->section] : [];

        $this->redirect($apiClient->getDashboardIframeUrl($secretKey, $params));
    }
}