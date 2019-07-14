<?php

namespace App\Tests\Service;

use App\Repository\TargetRepository;
use App\Service\RuleService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RuleServiceTest extends WebTestCase
{
    /**
     * @dataProvider dataProvider
     *
     * @param string $targetValue
     * @param object $object
     * @param bool $expected
     */
    public function testEvaluate(string $targetValue, object $object, bool $expected)
    {
        $service = $this->getRuleService();
        if ($expected) {
            $this->assertTrue($service->evaluate($targetValue, $object));
            return;
        }

        $this->assertFalse($service->evaluate($targetValue, $object));
    }

    public function dataProvider(): \Generator
    {
        $object = (object)[
            'id' => 1,
            'sku' => 'PLA 122-002296',
        ];
        yield [
            'product',
            $object,
            true,
        ];
        $object = (object)[
            'id' => 1,
            'sku' => 'PLA 122-002296',
        ];
        yield [
            'package',
            $object,
            false,
        ];
    }

    private function getRuleService(): RuleService
    {
        $client = self::createClient();
        /** @var TargetRepository $targetRepository */
        $targetRepository = $client->getContainer()->get('test.' . TargetRepository::class);

        return new RuleService($targetRepository);
    }
}
