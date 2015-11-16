<?php
namespace Resources\Behat;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;

/**
 * Behat context class.
 */
class WebContext extends MinkContext implements KernelAwareContext, SnippetAcceptingContext
{
    private $output;
    use LoginWebTrait;
    use ScreenshotTrait;
    use Symfony2Trait;

    /**
     * @Transform :property
     *
     * @param $propertyName
     *
     * @return string
     */
    public function transformPropertyNameIntoFormPropertyName($propertyName)
    {
        return 'form_'.lcfirst(str_replace(' ', '', $propertyName));
    }

    /**
     * @When I fill :property with :propertyValue
     *
     * @param $property
     * @param $propertyValue
     */
    public function iFillWith($property, $propertyValue)
    {
        $this->fillField($property, $propertyValue);
    }

    /**
     * @Then I should see :text in the output
     *
     * @param $text
     *
     * @throws \Exception
     */
    public function iShouldSeeInTheOutput($text)
    {
        if (strpos($this->output, $text) === false) {
            throw new \Exception('Could not find text '.$text);
        }
    }

    /**
     * @When I click :text
     *
     * @param $text
     */
    public function iClick($text)
    {
        $this->clickLink($text);
    }

    /**
     * @Then /^I should see "([^"]+)" on page headline$/
     *
     * @param $text
     *
     * @throws \Exception
     */
    public function iShouldSeeTextOnPageHeadline($text)
    {
        $result = $this->getSession()->getPage()->find('xpath', '//h1[contains(., "'.$text.'")]');

        if (null === $result) {
            $msg = "Text '$text' was not found on page headline";
            throw new \Exception($msg);
        };
    }

    /**
     * Checks, that URL is equal to specified.
     *
     * @Then /^url is "(?P<url>[^"]+)"$/
     *
     * @param $url
     *
     * @throws \Exception
     */
    public function assertUrl($url)
    {
        $expectedUrl = $this->locatePath($url);

        $actualUrl = $this->getSession()->getCurrentUrl();

        if ($expectedUrl !== $actualUrl) {
            $msg = sprintf('Current url is "%s", but "%s" expected.', $actualUrl, $expectedUrl);
            throw new \Exception($msg);
        }
    }

    /**
     * Attaches file to field with specified xpath.
     *
     * @When /^(?:|I )attach the file "(?P<path>[^"]*)" using xpath to "(?P<field>(?:[^"]|\\")*)"$/
     *
     * @param $field
     * @param $path
     */
    public function iAttachTheFileUsingXpathToInputType($field, $path)
    {
        $session  = $this->getSession();
        $selector = $session->getSelectorsHandler()->selectorToXpath('xpath', $field);
        $element  = $session->getPage()->find('xpath', $selector);

        $this->attachFileToField($element->getAttribute('id'), $path);
    }
}
