<?php

declare(strict_types = 1);

namespace Tests\unit;

use PHPUnit\Framework\TestCase;


/**
 * Class ATestTest
 *
 * @package Tests\unit
 */
class TestTest extends TestCase
{
    /**
     * @path to data json
     */
    const TEST_DATA_PATH = __DIR__ . '/../data/';

    const TEST_DATA_FILE_NAME = 'social-posts-response.json';

    const TEST_DATA_POST_NUMBER = 4;


    /**
     * @test
     */
    /*
    public function testNothing(): void
    {
        $this->assertTrue(true);
    }*/

    /**
     * @testFetchPosts
     */
    public function testFetchPosts(): void
    {
        $postInfo = array();

        $this->assertFileExists(
            self::TEST_DATA_PATH . self::TEST_DATA_FILE_NAME
        );

        $response = file_get_contents(self::TEST_DATA_PATH . self::TEST_DATA_FILE_NAME);

        $responseData = empty($response) ? null : \GuzzleHttp\json_decode($response, true);

        $posts = $responseData['data']['posts'] ?? null;

        $this->assertNotNull(
            $posts
        );

        $hydrator = new \SocialPost\Hydrator\FictionalPostHydrator;
        
        foreach ($posts as $postData) {
            $postInfo[] = $hydrator->hydrate($postData);
        }
        
        $this->assertCount(
            self::TEST_DATA_POST_NUMBER,
            $postInfo
        );

    }


}
