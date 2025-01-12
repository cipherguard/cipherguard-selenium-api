<?php
/**
 * Cipherguard ~ Open source password manager for teams
 * Copyright (c) KhulnaSoft Ltd (https://www.khulnasoft.com)
 *
 * Licensed under GNU Affero General Public License version 3 of the or any later version.
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) KhulnaSoft Ltd (https://www.khulnasoft.com)
 * @license       https://opensource.org/licenses/AGPL-3.0 AGPL License
 * @link          https://www.khulnasoft.com KhulnaSoft(tm)
 * @since         2.0.0
 */
use Cake\Core\Configure;

if (Configure::read('debug') && Configure::read('cipherguard.selenium.active')) {
    $overrideOptions = Configure::read('cipherguard.plugins.selenium_api.security.endpoints');

    Configure::load('CipherguardSeleniumApi.config', 'default', true);

    if (!empty($overrideOptions) && is_array($overrideOptions)) {
        $default = Configure::read('cipherguard.plugins.selenium_api.security.endpoints');
        $finalEndpointsConfig = array_merge($default, $overrideOptions);

        Configure::write('cipherguard.plugins.selenium_api.security.endpoints', $finalEndpointsConfig);
    }
}
