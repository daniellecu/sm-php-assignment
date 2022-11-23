<?php

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

/**
 * Class Calculator
 *
 * @package Statistics\Calculator
 */
class AveragePostNumberPerUser extends AbstractCalculator
{

    protected const UNITS = 'posts';

    /**
     * @var array
     */
    public $postUserIDs = [];


    /**
     * @var int
     */
    private $postCount = 0;

    /**
     * @param SocialPostTo $postTo
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {

        if(!in_array($postTo->getAuthorId(), $this->postUserIDs, true)){
            $this->postUserIDs[] = $postTo->getAuthorId(); 
        }

        $this->postCount++;

    }

    /**
     * @return StatisticsTo
     */
    protected function doCalculate(): StatisticsTo
    {
        $value = count($this->postUserIDs) > 0
            ? $this->postCount / count($this->postUserIDs) 
            : 0;

        return (new StatisticsTo())->setValue(round($value,2));
    }
}
