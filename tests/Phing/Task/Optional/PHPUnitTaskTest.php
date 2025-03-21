<?php

/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information please see
 * <http://phing.info>.
 */

namespace Phing\Test\Task\Optional;

use Phing\Test\Support\BuildFileTest;

/**
 * Unit tests for PHPUnit task.
 *
 * @internal
 */
class PHPUnitTaskTest extends BuildFileTest
{
    protected $backupGlobals = false;

    public function setUp(): void
    {
        $this->configureProject(PHING_TEST_BASE . '/etc/tasks/ext/phpunit/build.xml');
    }

    /**
     * Regression test for http://www.phing.info/trac/ticket/655
     * "PlainPHPUnitResultFormatter does not display errors if dataProvider was used".
     */
    public function testPlainFormatterDataProvider(): void
    {
        $this->executeTarget(__FUNCTION__);
        $this->assertInLogs('Tests run: 2, Risky: 0, Warnings: 0, Failures: 1, Errors: 0, Incomplete: 0, Skipped: 0, Time elapsed:');
    }

    /**
     * Regression test for ticket http://www.phing.info/trac/ticket/363
     * "PHPUnit task fails with formatter type 'xml'".
     */
    public function testXmlFormatter(): void
    {
        $this->executeTarget(__FUNCTION__);
        $this->assertInLogs('<testcase name="testSayHello" class="HelloWorldTest"');
    }

    /**
     * Regression test for ticket http://www.phing.info/trac/ticket/893.
     */
    public function testDoubleAutoloader(): void
    {
        $this->executeTarget(__FUNCTION__);
    }

    /**
     * Regression test for ticket http://www.phing.info/trac/ticket/945.
     */
    public function testShouldNotIgnoreFailuresAfterError(): void
    {
        $this->expectBuildException(__FUNCTION__, 'Fail');
    }

    /**
     * Regression test for ticket http://www.phing.info/trac/ticket/1159.
     */
    public function testExcludeGroups(): void
    {
        $this->expectNotToPerformAssertions();
        $this->executeTarget(__FUNCTION__);
    }
}
