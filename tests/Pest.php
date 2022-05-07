<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/


use Igorsgm\Ghost\Tests\TestCase;

uses(TestCase::class)->in('Feature');
uses(TestCase::class)->in('Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Call protected/private method of a class.
 *
 * @param  object &$object  Instantiated object that we will run method on.
 * @param  string  $methodName  Method name to call
 * @param  array  $parameters  Array of parameters to pass into method.
 *
 * @return mixed Method return.
 */
function invokeMethod(&$object, $methodName, array $parameters = [])
{
    $reflection = new \ReflectionClass(get_class($object));
    $method = $reflection->getMethod($methodName);
    $method->setAccessible(true);

    return $method->invokeArgs($object, $parameters);
}

/**
 * @param \Igorsgm\Ghost\Apis\BaseApi $ghost
 * @param string $parameter
 * @param string $value
 * @return void
 */
function expectParameterSet($ghost, $parameter, $value)
{
    expect($ghost->$parameter)->toEqual($value);

    $queryString = invokeMethod($ghost, 'buildParams');
    parse_str($queryString, $parsedQueryString);

    expect($parsedQueryString)->toHaveKey('key');

    unset($parsedQueryString['key']);
    expect($parsedQueryString)->toMatchArray([
        $parameter => $value
    ]);
}
