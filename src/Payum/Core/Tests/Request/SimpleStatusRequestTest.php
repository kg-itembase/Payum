<?php
namespace Payum\Core\Tests\Request;

use Payum\Core\Request\SimpleStatusRequest;

class SimpleStatusRequestTest extends \PHPUnit_Framework_TestCase
{
    public static function provideIsXXXMethods()
    {
        return array(
            array('isSuccess'),
            array('isCanceled'),
            array('isPending'),
            array('isFailed'),
            array('isNew'),
            array('isUnknown'),
            array('isSuspended'),
            array('isExpired')
        );
    }

    public static function provideMarkXXXMethods()
    {
        return array(
            array('markSuccess'),
            array('markCanceled'),
            array('markPending'),
            array('markFailed'),
            array('markNew'),
            array('markUnknown'),
            array('markSuspended'),
            array('markExpired')
        );
    }

    /**
     * @test
     */
    public function shouldBeSubClassOfBaseStatusRequest()
    {
        $rc = new \ReflectionClass('Payum\Core\Request\SimpleStatusRequest');

        $this->assertTrue($rc->isSubclassOf('Payum\Core\Request\BaseStatusRequest'));
    }

    /**
     * @test
     */
    public function shouldMarkUnknownInConstructor()
    {
        $statusRequest = new SimpleStatusRequest(new \stdClass);

        $this->assertTrue($statusRequest->isUnknown());
    }

    /**
     * @test
     * 
     * @dataProvider provideMarkXXXMethods
     */
    public function shouldAllowGetMarkedStatus($markXXXMethod)
    {
        $statusRequest = new SimpleStatusRequest(new \stdClass);

        $statusRequest->$markXXXMethod();
        
        $this->assertNotEmpty($statusRequest->getStatus());
    }

    /**
     * @test
     *
     * @dataProvider provideIsXXXMethods
     */
    public function shouldCallIsXXXStatus($isXXXMethod)
    {
        $statusRequest = new SimpleStatusRequest(new \stdClass);

        $this->assertInternalType('boolean', $statusRequest->$isXXXMethod());
    }

    /**
     * @test
     */
    public function shouldNotMatchOthersThenSuccessStatus()
    {
        $statusRequest = new SimpleStatusRequest(new \stdClass);

        $statusRequest->markSuccess();
        
        $this->assertTrue($statusRequest->isSuccess());
        
        $this->assertFalse($statusRequest->isCanceled());
        $this->assertFalse($statusRequest->isSuspended());
        $this->assertFalse($statusRequest->isExpired());
        $this->assertFalse($statusRequest->isPending());
        $this->assertFalse($statusRequest->isFailed());
        $this->assertFalse($statusRequest->isNew());
        $this->assertFalse($statusRequest->isUnknown());
    }

    /**
     * @test
     */
    public function shouldNotMatchOthersThenFailedStatus()
    {
        $statusRequest = new SimpleStatusRequest(new \stdClass);

        $statusRequest->markFailed();

        $this->assertTrue($statusRequest->isFailed());
        
        $this->assertFalse($statusRequest->isSuccess());
        $this->assertFalse($statusRequest->isSuspended());
        $this->assertFalse($statusRequest->isExpired());
        $this->assertFalse($statusRequest->isCanceled());
        $this->assertFalse($statusRequest->isPending());
        $this->assertFalse($statusRequest->isNew());
        $this->assertFalse($statusRequest->isUnknown());
    }

    /**
     * @test
     */
    public function shouldNotMatchOthersThenPendingStatus()
    {
        $statusRequest = new SimpleStatusRequest(new \stdClass);

        $statusRequest->markPending();

        $this->assertTrue($statusRequest->isPending());
        
        $this->assertFalse($statusRequest->isFailed());
        $this->assertFalse($statusRequest->isSuspended());
        $this->assertFalse($statusRequest->isExpired());
        $this->assertFalse($statusRequest->isSuccess());
        $this->assertFalse($statusRequest->isCanceled());
        $this->assertFalse($statusRequest->isNew());
        $this->assertFalse($statusRequest->isUnknown());
    }

    /**
     * @test
     */
    public function shouldNotMatchOthersThenCanceledStatus()
    {
        $statusRequest = new SimpleStatusRequest(new \stdClass);

        $statusRequest->markCanceled();

        $this->assertTrue($statusRequest->isCanceled());
        
        $this->assertFalse($statusRequest->isPending());
        $this->assertFalse($statusRequest->isSuspended());
        $this->assertFalse($statusRequest->isExpired());
        $this->assertFalse($statusRequest->isFailed());
        $this->assertFalse($statusRequest->isSuccess());
        $this->assertFalse($statusRequest->isNew());
        $this->assertFalse($statusRequest->isUnknown());
    }

    /**
     * @test
     */
    public function shouldNotMatchOthersThenNewStatus()
    {
        $statusRequest = new SimpleStatusRequest(new \stdClass);

        $statusRequest->markNew();

        $this->assertTrue($statusRequest->isNew());

        $this->assertFalse($statusRequest->isSuccess());
        $this->assertFalse($statusRequest->isSuspended());
        $this->assertFalse($statusRequest->isExpired());
        $this->assertFalse($statusRequest->isCanceled());
        $this->assertFalse($statusRequest->isPending());
        $this->assertFalse($statusRequest->isFailed());
        $this->assertFalse($statusRequest->isUnknown());
    }

    /**
     * @test
     */
    public function shouldNotMatchOthersThenUnknownStatus()
    {
        $statusRequest = new SimpleStatusRequest(new \stdClass);

        $statusRequest->markUnknown();

        $this->assertTrue($statusRequest->isUnknown());

        $this->assertFalse($statusRequest->isSuccess());
        $this->assertFalse($statusRequest->isSuspended());
        $this->assertFalse($statusRequest->isExpired());
        $this->assertFalse($statusRequest->isCanceled());
        $this->assertFalse($statusRequest->isPending());
        $this->assertFalse($statusRequest->isFailed());
        $this->assertFalse($statusRequest->isNew());
    }

    /**
     * @test
     */
    public function shouldNotMatchOthersThenExpiredStatus()
    {
        $statusRequest = new SimpleStatusRequest(new \stdClass);

        $statusRequest->markExpired();

        $this->assertTrue($statusRequest->isExpired());

        $this->assertFalse($statusRequest->isSuccess());
        $this->assertFalse($statusRequest->isSuspended());
        $this->assertFalse($statusRequest->isCanceled());
        $this->assertFalse($statusRequest->isPending());
        $this->assertFalse($statusRequest->isFailed());
        $this->assertFalse($statusRequest->isNew());
        $this->assertFalse($statusRequest->isUnknown());
    }

    /**
     * @test
     */
    public function shouldNotMatchOthersThenSuspendedStatus()
    {
        $statusRequest = new SimpleStatusRequest(new \stdClass);

        $statusRequest->markSuspended();

        $this->assertTrue($statusRequest->isSuspended());

        $this->assertFalse($statusRequest->isSuccess());
        $this->assertFalse($statusRequest->isExpired());
        $this->assertFalse($statusRequest->isCanceled());
        $this->assertFalse($statusRequest->isPending());
        $this->assertFalse($statusRequest->isFailed());
        $this->assertFalse($statusRequest->isNew());
        $this->assertFalse($statusRequest->isUnknown());
    }
}

