<?php
namespace spec\App\Utils;

use App\Utils\ModelUtil;
use PhpSpec\ObjectBehavior;

class ModelUtilSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ModelUtil::class);
    }
}
