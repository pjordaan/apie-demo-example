<?php
namespace App\Apie\Collection\ValueObjects;

use Apie\Core\Attributes\FakeMethod;
use Apie\Core\ValueObjects\Interfaces\HasRegexValueObjectInterface;
use Apie\Core\ValueObjects\IsStringWithRegexValueObject;
use Faker\Generator;

#[FakeMethod('createRandom')]
final class CollectableName implements HasRegexValueObjectInterface
{
    use IsStringWithRegexValueObject;

    public static function getRegularExpression(): string
    {
        return '/^\w[\s\w]{0,60}\w$/';
    }

    protected function convert(string $input): string
    {
        return trim($input);
    }

    public static function createRandom(Generator $faker): self
    {
        if ($faker->boolean()) {
            return new self($faker->word());
        }
        if ($faker->boolean()) {
            return new self($faker->colorName() . ' ' . $faker->randomElement(['Pikachu', 'Spongebob', 'Peppa Pig']));
        }
        return new self($faker->word() . ' ' . $faker->word());
    }
}