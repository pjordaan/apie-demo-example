<?php
namespace App\Apie\Collection\ValueObjects;

use Apie\Core\Attributes\FakeMethod;
use Apie\Core\Attributes\SchemaMethod;
use Apie\Core\ValueObjects\Interfaces\ValueObjectInterface;
use Apie\Core\ValueObjects\Utils;

#[SchemaMethod('createSchema')]
#[FakeMethod('createRandom')]
final class CollectableAmount implements ValueObjectInterface
{
    public function __construct(private readonly int $amount)
    {
        if ($amount <= 0) {
            throw new \UnexpectedValueException('Value "' . $amount . '" is lower or equal than 0');
        }
    }

    public static function fromNative(mixed $input): CollectableAmount
    {
        return new static(Utils::toInt($input));
    }

    public function toNative(): int
    {
        return $this->amount;
    }

    public static function createRandom(): self
    {
        return new self(random_int(1, 12));
    }

    public static function createSchema(): array
    {
        return [
            'type' => 'int',
            'minimum' => 1,
        ];
    }
}