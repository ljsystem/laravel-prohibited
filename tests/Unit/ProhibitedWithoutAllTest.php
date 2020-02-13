<?php

namespace Ljsystem\Prohibited\Tests;

use Illuminate\Support\Facades\Validator;
use Ljsystem\Prohibited\ProhibitedServiceProvider;
use Orchestra\Testbench\TestCase;

class ProhibitedWithoutAllTest extends TestCase
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

    public function testWithoutOneProhibitedAttribute(): void
    {
        $this->request->merge([
            'firstAttribute' => '1',
            'otherAttribute' => 'a',
            'anotherAttribute' => 'b',
        ]);

        $validation = Validator::make($this->request->all(), [
            'firstAttribute' => 'prohibited_without_all:secondAttribute',
        ]);

        $this->assertTrue($validation->fails());
        $this->assertTrue($validation->errors()->has('firstAttribute'));
        $this->assertEquals('The first attribute is prohibited without all second attribute.', $validation->errors()->first('firstAttribute'));
    }

    public function testWithOneProhibitedAttribute(): void
    {
        $this->request->merge([
            'firstAttribute' => '1',
            'secondAttribute' => '2',
            'otherAttribute' => 'a',
            'anotherAttribute' => 'b',
        ]);

        $validation = Validator::make($this->request->all(), [
            'firstAttribute' => 'prohibited_without_all:secondAttribute',
        ]);

        $this->assertFalse($validation->fails());
    }

    public function testWithoutMultipleProhibitedAttributes(): void
    {
        $this->request->merge([
            'firstAttribute' => '1',
            'otherAttribute' => 'a',
            'anotherAttribute' => 'b',
        ]);

        $validation = Validator::make($this->request->all(), [
            'firstAttribute' => 'prohibited_without_all:secondAttribute,thirdAttribute',
        ]);

        $this->assertTrue($validation->fails());
        $this->assertTrue($validation->errors()->has('firstAttribute'));
        $this->assertEquals('The first attribute is prohibited without all second attribute, third attribute.', $validation->errors()->first('firstAttribute'));
    }

    public function testWithSomeMultipleProhibitedAttributes(): void
    {
        $this->request->merge([
            'firstAttribute' => '1',
            'secondAttribute' => '2',
            'otherAttribute' => 'a',
            'anotherAttribute' => 'b',
        ]);

        $validation = Validator::make($this->request->all(), [
            'firstAttribute' => 'prohibited_without_all:secondAttribute,thirdAttribute',
        ]);

        $this->assertTrue($validation->fails());
        $this->assertTrue($validation->errors()->has('firstAttribute'));
        $this->assertEquals('The first attribute is prohibited without all second attribute, third attribute.', $validation->errors()->first('firstAttribute'));
    }

    public function testWithMultipleProhibitedAttributes(): void
    {
        $this->request->merge([
            'firstAttribute' => '1',
            'secondAttribute' => '2',
            'thirdAttribute' => '3',
            'otherAttribute' => 'a',
            'anotherAttribute' => 'b',
        ]);

        $validation = Validator::make($this->request->all(), [
            'firstAttribute' => 'prohibited_without_all:secondAttribute,thirdAttribute',
        ]);

        $this->assertFalse($validation->fails());
    }
}
