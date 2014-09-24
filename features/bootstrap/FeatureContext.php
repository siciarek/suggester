<?php

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../app/'));

// Create service container
$di = new \Phalcon\DI\FactoryDefault\CLI();
$application = new \Phalcon\CLI\Console();

require_once APPLICATION_PATH . '/autoload.php';

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Application\Frontend\Entity\Suggestion;

/**
 * Behat context class.
 */
class FeatureContext extends Behat\MinkExtension\Context\MinkContext implements SnippetAcceptingContext {

    protected static $clean = false;
    protected $di;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context object.
     * You can also pass arbitrary arguments to the context constructor through behat.yml.
     */
    public function __construct() {
        $this->di = \Phalcon\Di::getDefault();
    }


    /**
     * @Given że aplikacja jest w środowisku produkcyjnym
     */
    public function zeAplikacjaJestWSrodowiskuProdukcyjnym()
    {
        if($this->di->getConfig()->application->env !== 'prod') {
            throw new \Exception('Apllication is not in "prod" environment.');
        }
    }

    /**
     * @Given że w systemie nie ma testowych danych
     */
    public function zeWSystemieNieMaTestowychDanych() {
        $suggestions = Suggestion::query()
//            ->where('author = :author:')
//            ->bind([ 'author' => 'Acceptance Test' ])
            ->execute();

        foreach ($suggestions as $s) {
            $s->delete();
        }
    }

    /**
     * @When /^(?:|że )wypełnię ukryte pole "(?P<field>(?:[^"]|\\")*)" wartością "(?P<value>(?:[^"]|\\")*)"$/
     */
    public function iFillHiddenFieldWith($field, $value) {
        if ($this->getSession()->getDriver() instanceof Behat\Mink\Driver\GoutteDriver) {
            $this->getSession()->getPage()->find('css',
                'input[name="' . $field . '"]')->setValue($value);
        }
    }

    /**
     * @When /^(?:|że )wypełnię pole o xpath "(?P<field>(?:[^"]|\\")*)" wartością "(?P<value>(?:[^"]|\\")*)"$/
     */
    public function iFillFieldWithXpath($field, $value) {
        $this->getSession()->getPage()->find('xpath',
            $this->getSession()->getSelectorsHandler()->selectorToXpath('xpath', $field)
        )->setValue($value);
    }

    /**
     * Checks, that current page response status is equal to specified.
     *
     */
    public function assertResponseStatus($code) {
        if ($this->getSession()->getDriver() instanceof Behat\Mink\Driver\GoutteDriver) {
            $this->assertSession()->statusCodeEquals($code);
        }
    }

    /**
     * Checks, that current page response status is not equal to specified.
     *
     */
    public function assertResponseStatusIsNot($code) {
        if ($this->getSession()->getDriver() instanceof Behat\Mink\Driver\GoutteDriver) {
            $this->assertSession()->statusCodeNotEquals($code);
        }
    }

    /**
     * @AfterStep
     *
     * Take screenshot when step fails.
     * Works only with Selenium2Driver.
     *
     * @param \Behat\Behat\Hook\Scope\AfterStepScope $scope
     */
    public function takeScreenshotAfterFailedStep(Behat\Behat\Hook\Scope\AfterStepScope $scope) {

        if (!is_dir('temp')) {
            mkdir('temp');
        }

        if (self::$clean === false) {
            $files = glob('temp/BEHAT*.png');
            array_map('unlink', $files);
            self::$clean = true;
        }

        if ($scope->getTestResult()->getResultCode() === Behat\Testwork\Tester\Result\TestResult::FAILED) {
            $driver = $this->getSession()->getDriver();
            if ($driver instanceof Behat\Mink\Driver\Selenium2Driver) {
                $feature = iconv('UTF-8', 'ASCII//TRANSLIT', $scope->getFeature()->getTitle());
                $line = $scope->getStep()->getLine();
                $description = iconv('UTF-8', 'ASCII//TRANSLIT', $scope->getStep()->getText());
                $description = preg_replace('/[^\s\w]/', '', $description);
                $image = sprintf('%s.%s.%s.png', $feature, $line, $description);
                file_put_contents('temp/BEHAT.' . $image, $driver->getScreenshot());
            }
        }
    }
}
