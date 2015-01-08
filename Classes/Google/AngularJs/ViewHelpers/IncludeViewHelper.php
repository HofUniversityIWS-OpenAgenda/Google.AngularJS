<?php
namespace Google\AngularJs\ViewHelpers;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "OpenAgenda.Application".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Class IncludeViewHelper
 *
 * **Usage**
 *
 * + include only base AngularJS file
 *
 *		`<ng:include />`
 *
 * + include minified version of base AngularJS file
 *
 *		`<ng:include min="1" />`
 *
 * + include e.g. AngularJS *AND* routing provider *AND* animation provider
 *
 *		`<ng:include route="1" animate="1" />`
 *
 * @package Google\AngularJs\ViewHelpers
 * @author Oliver Hader <oliver@typo3.org>
 */
class IncludeViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * The TYPO3 Flow resource publisher.
	 *
	 * @var \TYPO3\Flow\Resource\Publishing\ResourcePublisher
	 * @Flow\Inject
	 */
	protected $resourcePublisher;

	/**
	 * The template to be used to render the HTML script tag.
	 *
	 * @var string
	 */
	protected $renderTemplate = '<script type="text/javascript" src="%s"></script>';

	/**
	 * The relative resource path inside the current TYPO3 Flow package.
	 *
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
	 * Renders the JavaScript resource inclusions as HTML script tags.
	 *
	 * @param NULL|bool $min Whether to use the minified version of resources
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
	 * Gets the published resource URI.
	 *
	 * @param string $name Name of the AngularJS component
	 * @param bool $min Whether to use the minified version of the resource
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
