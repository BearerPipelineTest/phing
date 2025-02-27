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

namespace Phing\Test\Task\Optional\Svn;

/**
 * @author Michiel Rook <mrook@php.net>
 *
 * @internal
 */
class SvnListTaskTest extends AbstractSvnTaskTest
{
    use SvnTaskTestSkip;

    public function setUp(): void
    {
        $this->markTestAsSkippedWhenSvnNotInstalled();
        $this->initialize('SvnListTest.xml');
        $this->rmdir(PHING_TEST_BASE . '/tmp/svn');
    }

    public function testGetList(): void
    {
        $this->executeTarget('getList');
        $this->assertPropertyEquals(
            'svn.list',
            '1560 | michiel.rook | 2012-04-06T18:33:25.000000Z | VERSION.TXT
1560 | michiel.rook | 2012-04-06T18:33:25.000000Z | coverage-frames.xsl
1560 | michiel.rook | 2012-04-06T18:33:25.000000Z | log.xsl
1560 | michiel.rook | 2012-04-06T18:33:25.000000Z | phing-grammar.rng
1560 | michiel.rook | 2012-04-06T18:33:25.000000Z | phpunit-frames.xsl
1560 | michiel.rook | 2012-04-06T18:33:25.000000Z | phpunit-noframes.xsl
1560 | michiel.rook | 2012-04-06T18:33:25.000000Z | str.replace.function.xsl'
        );
    }
}
