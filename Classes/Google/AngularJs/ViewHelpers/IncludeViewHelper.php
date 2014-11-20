<?php
namespace Google\AngularJs\ViewHelpers;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "OpenAgenda.Application".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

class IncludeViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @var \TYPO3\Flow\Resource\Publishing\ResourcePublisher
	 * @Flow\Inject
	 */
	protected $resourcePublisher;

	/**
	 * @var string
	 */
	protected $renderTemplate = '<link rel="stylesheet" href="%s" />';

	/**
	 * @var string
	 */
	protected $staticResourcePath = 'Packages/Google.AngularJs/Libraries/angular/';

	/**
	 * Initialize arguments
	 *
	 * @return void
	 * @api
	 */
	public function initializeArguments() {
		$this->registerArgument('animate', 'boolean', 'Includes ngAnimate');
		$this->registerArgument('aria', 'boolean', 'Includes ngAria');
		$this->registerArgument('cookies', 'boolean', 'Includes ngCookies');
		$this->registerArgument('loader', 'boolean', 'Includes ngLoader');
		$this->registerArgument('message', 'boolean', 'Includes ngMessage');
		$this->registerArgument('resource', 'boolean', 'Includes ngResource');
		$this->registerArgument('route', 'boolean', 'Includes ngRoute');
		$this->registerArgument('sanitize', 'boolean', 'Includes ngSanitize');
		$this->registerArgument('touch', 'boolean', 'Includes ngTouch');
	}

	/**
	 * @param NULL|bool $min
	 * @return string
	 */
	public function render($min = NULL) {
		$content = '';

		if ($min === NULL) {
			$min = \TYPO3\Flow\Core\Bootstrap::$staticObjectManager->getContext()->isProduction();
		}

		$content .= $this->getResourceUri('angular', $min);
		foreach ($this->arguments as $argumentName => $argumentValue) {
			if ($argumentValue && $argumentName !== 'min') {
				$content .= $this->getResourceUri('angular-' . $argumentName, $min);
			}
		}

		return $content;
	}

	/**
	 * @param string $name
	 * @param bool $min
	 * @return string
	 */
	protected function getResourceUri($name, $min = FALSE) {
		return sprintf(
			$this->renderTemplate . PHP_EOL,
			$this->resourcePublisher->getStaticResourcesWebBaseUri()
				. $this->staticResourcePath
				. $name . ($min ? '.min' : '') . '.js'
		);
	}

}
