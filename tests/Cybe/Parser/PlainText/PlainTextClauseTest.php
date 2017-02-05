<?php

namespace MemMemov\Cybe\Parser\PlainText;

class PlainTextClauseTest extends \PHPUnit_Framework_TestCase
{
    /** @var PlainTextPredicates|\PHPUnit_Framework_MockObject_MockObject */
    protected $predicates;
    /** @var PlainTextSubjects|\PHPUnit_Framework_MockObject_MockObject */
    protected $subjects;
    /** @var PlainTextArguments|\PHPUnit_Framework_MockObject_MockObject */
    protected $arguments;

    protected function setUp()
    {
        $this->predicates = $this->getMockBuilder(PlainTextPredicates::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subjects = $this->getMockBuilder(PlainTextSubjects::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->arguments = $this->getMockBuilder(PlainTextArguments::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testItHasPredicate()
    {
        $string = 'врач.ставить(что:диагноз,кому:больной,когда:сейчас)';

        $clause = new PlainTextClause($this->predicates, $this->subjects, $this->arguments, $string);

        $predicate = $this->getMockBuilder(PlainTextPredicate::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->predicates->expects($this->once())
            ->method('create')
            ->with('ставить')
            ->willReturn($predicate);

        $result = $clause->predicate();

        $this->assertSame($predicate, $result);
    }

    public function testItHasSubject()
    {
        $string = 'врач.ставить(что:диагноз,кому:больной,когда:сейчас)';

        $clause = new PlainTextClause($this->predicates, $this->subjects, $this->arguments, $string);

        $subject = $this->getMockBuilder(PlainTextSubject::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subjects->expects($this->once())
            ->method('create')
            ->with('врач')
            ->willReturn($subject);

        $result = $clause->subject();

        $this->assertSame($subject, $result);
    }

    public function testItHasArguments()
    {
        $string = 'врач.ставить(что:диагноз,кому:больной,когда:сейчас)';

        $clause = new PlainTextClause($this->predicates, $this->subjects, $this->arguments, $string);

        $argument_1 = $this->getMockBuilder(PlainTextArgument::class)
            ->disableOriginalConstructor()
            ->getMock();

        $argument_2 = $this->getMockBuilder(PlainTextArgument::class)
            ->disableOriginalConstructor()
            ->getMock();

        $argument_3 = $this->getMockBuilder(PlainTextArgument::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->arguments->expects($this->exactly(3))
            ->method('create')
            ->withConsecutive(
                ['что:диагноз'],
                ['кому:больной'],
                ['когда:сейчас']
            )
            ->will($this->onConsecutiveCalls($argument_1, $argument_2, $argument_3));

        $result = $clause->arguments();

        $this->assertEquals([$argument_1, $argument_2, $argument_3], $result);
    }
}