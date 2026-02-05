<?php

namespace Skywalker\Html;

use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Contracts\View\Factory;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class ThemeTest extends TestCase
{
    protected $formBuilder;
    protected $urlGenerator;
    protected $viewFactory;
    protected $htmlBuilder;

    protected function setUp(): void
    {
        $this->urlGenerator = new UrlGenerator(new RouteCollection(), Request::create('/foo', 'GET'));
        $this->viewFactory = m::mock(Factory::class);
        $this->htmlBuilder = new HtmlBuilder($this->urlGenerator, $this->viewFactory);
        $this->formBuilder = new FormBuilder($this->htmlBuilder, $this->urlGenerator, $this->viewFactory, 'abc');
    }

    protected function tearDown(): void
    {
        m::close();
    }

    public function testTailwindThemeIsApplied()
    {
        $this->formBuilder->tailwind();

        $input = $this->formBuilder->text('name');
        $this->assertStringContainsString('border rounded px-4 py-2', (string) $input);

        $textarea = $this->formBuilder->textarea('bio');
        $this->assertStringContainsString('border rounded px-4 py-2', (string) $textarea);

        $select = $this->formBuilder->select('size', ['L' => 'Large']);
        $this->assertStringContainsString('border rounded px-4 py-2', (string) $select);

        $label = $this->formBuilder->label('name');
        $this->assertStringContainsString('block text-gray-700 text-sm font-bold', (string) $label);

        $submit = $this->formBuilder->submit('Save');
        $this->assertStringContainsString('bg-blue-500 hover:bg-blue-600', (string) $submit);

        // Test specialized components integration
        $email = $this->formBuilder->email('email');
        $this->assertStringContainsString('border rounded px-4 py-2', (string) $email);

        $number = $this->formBuilder->number('age');
        $this->assertStringContainsString('border rounded px-4 py-2', (string) $number);

        $selectMonth = $this->formBuilder->selectMonth('birth_month');
        $this->assertStringContainsString('border rounded px-4 py-2', (string) $selectMonth);
    }

    public function testBootstrapThemeIsApplied()
    {
        $this->formBuilder->bootstrap();

        $input = $this->formBuilder->text('name');
        $this->assertStringContainsString('form-control', (string) $input);

        $textarea = $this->formBuilder->textarea('bio');
        $this->assertStringContainsString('form-control', (string) $textarea);

        $select = $this->formBuilder->select('size', ['L' => 'Large']);
        $this->assertStringContainsString('form-select', (string) $select);

        $label = $this->formBuilder->label('name');
        $this->assertStringContainsString('form-label', (string) $label);

        $submit = $this->formBuilder->submit('Save');
        $this->assertStringContainsString('btn btn-primary', (string) $submit);
    }

    public function testCustomClassesAreMergedWithThemeClasses()
    {
        $this->formBuilder->bootstrap();

        $input = $this->formBuilder->text('name', null, ['class' => 'my-custom-class']);
        $this->assertStringContainsString('my-custom-class form-control', (string) $input);
    }

    public function testThemeCanBeReset()
    {
        $this->formBuilder->tailwind();
        $this->formBuilder->theme(null);

        $input = $this->formBuilder->text('name');
        $this->assertStringNotContainsString('border rounded', (string) $input);
    }
}
