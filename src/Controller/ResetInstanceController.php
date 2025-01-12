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
namespace CipherguardSeleniumApi\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Http\Exception\NotFoundException;
use Cake\TestSuite\ConsoleIntegrationTestTrait;

class ResetInstanceController extends AppController
{
    use ConsoleIntegrationTestTrait;

    /**
     * @inheritDoc
     */
    public function beforeFilter(EventInterface $event)
    {
        if (Configure::read('debug') && Configure::read('cipherguard.selenium.active')) {
            $this->Authentication->allowUnauthenticated(['resetInstance']);
        } else {
            throw new NotFoundException();
        };

        return parent::beforeFilter($event);
    }

    /**
     * Reset cipherguard instance data. All data will be lost
     * This is same as calling the cake shell : cake install [--data=[default|...]]
     *
     * @param string $dataset data set name
     * @return void
     */
    public function resetInstance($dataset = 'default')
    {
        // Install job command.
        $this->useCommandRunner();
        $this->exec('cipherguard install --quick --quiet --no-admin --force --data ' . $dataset);

        $this->viewBuilder()
            ->setLayout('ajax')
            ->setTemplatePath('Healthcheck')
            ->setTemplate('status');
        $msg = __('Instance reset completed.');
        $this->success($msg, $msg);
    }
}
