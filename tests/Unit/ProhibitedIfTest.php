<?php

namespace Ljsystem\Prohibited\Tests\Unit;

use Illuminate\Support\Facades\Validator;
use Ljsystem\Prohibited\ProhibitedServiceProvider;
use Orchestra\Testbench\TestCase;

class ProhibitedIfTest extends TestCase
{
    private $request;

    protected function getPackageProviders($app): array
    {
        return [
            ProhibitedServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = request();
    }

    public function testWithoutOneProhibitedAttributeAndValue(): void
    {
        $this->request->merge([
            'firstAttribute' => '1',
            'otherAttribute' => 'a',
            'anotherAttribute' => 'b',
        ]);

        $validation = Validator::make($this->request->all(), [
            'firstAttribute' => 'prohibited_if:secondAttribute,2',
        ]);

        $this->assertFalse($validation->fails());
    }

    public function testWithOneProhibitedAttributeAndValue(): void
    {
        $this->request->merge([
            'firstAttribute' => '1',
            'secondAttribute' => '2',
            'otherAttribute' => 'a',
            'anotherAttribute' => 'b',
        ]);

        $validation = Validator::make($this->request->all(), [
            'firstAttribute' => 'prohibited_if:secondAttribute,2',
        ]);

        $this->assertTrue($validation->fails());
        $this->assertTrue($validation->errors()->has('firstAttribute'));
        $this->assertEquals('The first attribute is prohibited if second attribute is 2.', $validation->errors()->first('firstAttribute'));
    }

    public function testWithoutMultipleProhibitedAttributeAndValues(): void
    {
        $this->request->merge([
            'firstAttribute' => '1',
            'otherAttribute' => 'a',
            'anotherAttribute' => 'b',
        ]);

        $validation = Validator::make($this->request->all(), [
            'firstAttribute' => 'prohibited_if:secondAttribute,2,3',
        ]);

        $this->assertFalse($validation->fails());
    }

    public function testWithMultipleProhibitedAttributeAndValues(): void
    {
        $this->request->merge([
            'firstAttribute' => '1',
            'secondAttribute' => '2',
            'otherAttribute' => 'a',
            'anotherAttribute' => 'b',
        ]);

        $validation = Validator::make($this->request->all(), [
            'firstAttribute' => 'prohibited_if:secondAttribute,2,3',
        ]);

        $this->assertTrue($validation->fails());
        $this->assertTrue($validation->errors()->has('firstAttribute'));
        $this->assertEquals('The first attribute is prohibited if second attribute is 2, 3.', $validation->errors()->first('firstAttribute'));
    }
}
