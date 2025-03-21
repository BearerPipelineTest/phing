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

namespace Phing\Test\Task\System;

use Phing\Io\DirectoryScanner;
use Phing\Test\Support\BuildFileTest;

/**
 * Tests the DefaultExcludes Task.
 *
 * @author  Siad Ardroumli
 *
 * @internal
 */
class DefaultExcludesTest extends BuildFileTest
{
    public function setUp(): void
    {
        $this->configureProject(
            PHING_TEST_BASE
            . '/etc/tasks/system/defaultexcludes-test.xml'
        );
        $this->executeTarget('setup');
    }

    public function tearDown(): void
    {
        $this->executeTarget('clean');
        $this->executeTarget('cleanup-excludes');
    }

    public function test1(): void
    {
        $expected = [
            '**/*~',
            '**/#*#',
            '**/.#*',
            '**/%*%',
            '**/CVS',
            '**/CVS/**',
            '**/.cvsignore',
            '**/SCCS',
            '**/SCCS/**',
            '**/vssver.scc',
            '**/.svn',
            '**/.svn/**',
            '**/._*',
            '**/.DS_Store',
            '**/.darcs',
            '**/.darcs/**',
            '**/.git',
            '**/.git/**',
            '**/.gitattributes',
            '**/.gitignore',
            '**/.gitmodules',
            '**/.hg',
            '**/.hg/**',
            '**/.hgignore',
            '**/.hgsub',
            '**/.hgsubstate',
            '**/.hgtags',
            '**/.bzr',
            '**/.bzr/**',
            '**/.bzrignore',
        ];

        $this->executeTarget(__FUNCTION__);

        $actualArray = DirectoryScanner::getDefaultExcludes();
        foreach ($expected as $key => $value) {
            $this->assertArrayHasKey($key, $actualArray);
            $this->assertSame($value, $actualArray[$key]);
        }
    }

    public function test2(): void
    {
        $expected = [
            '**/*~',
            '**/#*#',
            '**/.#*',
            '**/%*%',
            '**/CVS',
            '**/CVS/**',
            '**/.cvsignore',
            '**/SCCS',
            '**/SCCS/**',
            '**/vssver.scc',
            '**/.svn',
            '**/.svn/**',
            '**/._*',
            '**/.DS_Store',
            '**/.darcs',
            '**/.darcs/**',
            '**/.git',
            '**/.git/**',
            '**/.gitattributes',
            '**/.gitignore',
            '**/.gitmodules',
            '**/.hg',
            '**/.hg/**',
            '**/.hgignore',
            '**/.hgsub',
            '**/.hgsubstate',
            '**/.hgtags',
            '**/.bzr',
            '**/.bzr/**',
            '**/.bzrignore',
            'foo',
        ];

        $this->executeTarget(__FUNCTION__);

        $actualArray = DirectoryScanner::getDefaultExcludes();
        foreach ($expected as $key => $value) {
            $this->assertArrayHasKey($key, $actualArray);
            $this->assertSame($value, $actualArray[$key]);
        }
    }

    public function test3(): void
    {
        $expected = [
            '**/*~',
            '**/#*#',
            '**/.#*',
            '**/%*%',
            // CVS missing
            '**/CVS/**',
            '**/.cvsignore',
            '**/SCCS',
            '**/SCCS/**',
            '**/vssver.scc',
            '**/.svn',
            '**/.svn/**',
            '**/._*',
            '**/.DS_Store',
            '**/.darcs',
            '**/.darcs/**',
            '**/.git',
            '**/.git/**',
            '**/.gitattributes',
            '**/.gitignore',
            '**/.gitmodules',
            '**/.hg',
            '**/.hg/**',
            '**/.hgignore',
            '**/.hgsub',
            '**/.hgsubstate',
            '**/.hgtags',
            '**/.bzr',
            '**/.bzr/**',
            '**/.bzrignore',
        ];

        $this->executeTarget(__FUNCTION__);

        $actualArray = DirectoryScanner::getDefaultExcludes();
        foreach ($expected as $key => $value) {
            $this->assertArrayHasKey($key, $actualArray);
            $this->assertSame($value, $actualArray[$key]);
        }
    }

    public function testCopyNoExplicitExcludes(): void
    {
        $this->executeTarget(__FUNCTION__);
        $output = $this->getProject()->getProperty('output');
        $this->assertFileExists(__DIR__ . '/../../../etc/tasks/system/defaultexcludes-test.xml');
        $this->assertFileDoesNotExist($output . '/.svn/entries');
    }

    public function testCopyExplicitExcludes(): void
    {
        $this->executeTarget(__FUNCTION__);
        $output = $this->getProject()->getProperty('output');
        $this->assertFileExists(__DIR__ . '/../../../etc/tasks/system/defaultexcludes-test.xml');
        $this->assertFileDoesNotExist($output . '/.svn/entries');
    }

    public function testCopyExplicitNoExcludes(): void
    {
        $this->executeTarget(__FUNCTION__);
        $output = $this->getProject()->getProperty('output');
        $this->assertFileExists(__DIR__ . '/../../../etc/tasks/system/defaultexcludes-test.xml');
        $this->assertFileExists($output . '/.svn/entries');
    }
}
