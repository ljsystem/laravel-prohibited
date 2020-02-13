<?php

namespace Ljsystem\Prohibited\Tests\Unit;

use Illuminate\Support\Facades\Validator;
use Ljsystem\Prohibited\ProhibitedServiceProvider;
use Orchestra\Testbench\TestCase;

class ProhibitedWithTest extends TestCase
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
            'firstAttribute' => 'prohibited_with:secondAttribute',
        ]);

        $this->assertFalse($validation->fails());
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
            'firstAttribute' => 'prohibited_with:secondAttribute',
        ]);

        $this->assertTrue($validation->fails());
        $this->assertTrue($validation->errors()->has('firstAttribute'));
        $this->assertEquals('The first attribute is prohibited with second attribute.', $validation->errors()->first('firstAttribute'));
    }

    public function testWithoutMultipleProhibitedAttributes(): void
    {
        $this->request->merge([
            'firstAttribute' => '1',
            'otherAttribute' => 'a',
            'anotherAttribute' => 'b',
        ]);

        $validation = Validator::make($this->request->all(), [
            'firstAttribute' => 'prohibited_with:secondAttribute,thirdAttribute',
        ]);

        $this->assertFalse($validation->fails());
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
            'firstAttribute' => 'prohibited_with:secondAttribute,thirdAttribute',
        ]);

        $this->assertTrue($validation->fails());
        $this->assertTrue($validation->errors()->has('firstAttribute'));
        $this->assertEquals('The first attribute is prohibited with second attribute, third attribute.', $validation->errors()->first('firstAttribute'));
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
            'firstAttribute' => 'prohibited_with:secondAttribute,thirdAttribute',
        ]);

        $this->assertTrue($validation->fails());
        $this->assertTrue($validation->errors()->has('firstAttribute'));
        $this->assertEquals('The first attribute is prohibited with second attribute, third attribute.', $validation->errors()->first('firstAttribute'));
    }
}
