<?php
namespace QuantumForms\Tests\Validators;

use QuantumForms\Autoloader;
use QuantumForms\Forms\Form;
use QuantumForms\JsErrorNotifiers\Alert;
use QuantumForms\FormElements\Input;
use QuantumForms\FormElementInterface;
use QuantumForms\FormInterface;

require_once 'src/Autoloader.php';
$loader = new Autoloader();

// register the autoloader
$loader->register();

// register the base directories for the namespace prefix
$loader->addNamespace('QuantumForms', 'src');

class FormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var QuantumForms\FormElementInterface
     */
    public $element;
    /**
     * Options set for the radio buttons
     * @var array
     */
    protected $options;

    /**
     * Run before each test is started.
     */
    public function setUp()
    {
        $this->element = new Form('get', '/test.php', new Alert());
    }

    /**
     * Run after each test is completed.
     */
    public function tearDown()
    {}

    public function testJsFunctionIsFunction()
    {
        $element = new Input('test');
        $this->assertTrue($element->setAttributes([]) instanceof FormElementInterface);
        $this->assertTrue($element->addAttribute('data-attribute', 'testData') instanceof FormElementInterface);
        $this->assertTrue($this->element->addElement(new Input('test'), 'test') instanceof FormInterface);
        $this->assertTrue($this->element->setHtmlBefore('<div>') instanceof FormInterface);
        $this->assertTrue($this->element->setHtmlAfter('</div>') instanceof FormInterface);
        
        $js = $this->element->renderJavascript();
        $this->assertTrue((bool)preg_match('/function[\W]*?\([\W,a-zA-Z0-9]*?\)[\W]*?\{.*\}/s', $js));
        $html = $this->element->renderHtml();
        $this->assertTrue(strpos($html, '<input') !== false);
    }
}