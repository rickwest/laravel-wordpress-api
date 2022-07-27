<?php

namespace RickWest\Wordpress\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use RickWest\Wordpress\Facades\Wordpress as WordpressFacade;
use RickWest\Wordpress\Resources\Categories;
use RickWest\Wordpress\Resources\Comments;
use RickWest\Wordpress\Resources\Media;
use RickWest\Wordpress\Resources\Pages;
use RickWest\Wordpress\Resources\Posts;
use RickWest\Wordpress\Resources\Resource;
use RickWest\Wordpress\Resources\Users;
use RickWest\Wordpress\Wordpress;

class WordpressTest extends TestCase
{
    public Wordpress $wordpress;

    public function setUp(): void
    {
        parent::setUp();

        Config::set('wordpress-api.url', 'https://example.com');

        $this->wordpress = app(Wordpress::class);
    }

    public function testCanBeInstantiated(): void
    {
        $this->assertInstanceOf(Wordpress::class, new Wordpress());
    }

    public function testFacadeReturnsInstanceOfWordpress(): void
    {
        $this->assertInstanceOf(Wordpress::class, WordpressFacade::getFacadeRoot());
    }

    public function testHelperReturnsInstanceOfWordpress(): void
    {
        $this->assertInstanceOf(Wordpress::class, wordpress());
    }

    /**
     * @dataProvider resourceNameClassProvider
     */
    public function testInstantiatesCorrectResourceClassMethodAccess($name, $class): void
    {
        $this->assertInstanceOf($class, $this->wordpress->$name());
    }

    /**
     * @dataProvider resourceNameClassProvider
     */
    public function testInstantiatesCorrectResourceClassPropertyAccess($name, $class): void
    {
        $this->assertInstanceOf($class, $this->wordpress->$name);
    }

    /**
     * @dataProvider resourceNameClassProvider
     */
    public function testInstantiatedResourceInstanceOfResourceMethodAccess($name): void
    {
        $this->assertInstanceOf(Resource::class, $this->wordpress->$name());
    }

    /**
     * @dataProvider resourceNameClassProvider
     */
    public function testInstantiatedResourceInstanceOfResourcePropertyAccess($name): void
    {
        $this->assertInstanceOf(Resource::class, $this->wordpress->$name);
    }

    /**
     * @dataProvider resourceNameClassProvider
     */
    public function testInstantiatesNewResourceClassMethodAccess($name): void
    {
        $this->assertNotSame($this->wordpress->$name(), $this->wordpress->$name());
    }

    /**
     * @dataProvider resourceNameClassProvider
     */
    public function testInstantiatesNewResourceClassPropertyAccess($name): void
    {
        $this->assertNotSame($this->wordpress->$name, $this->wordpress->$name);
    }

    public function testIncorrectResourceNameThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->wordpress->unknown();
    }

    /**
     * @dataProvider resourceNameClassProvider
     */
    public function testResourceGetCallsCorrectEndpoint($name): void
    {
        Http::fake();

        $this->wordpress->$name->get();

        Http::assertSent(function (Request $request) use ($name) {
            return $request->url() === "https://example.com/wp-json/wp/v2/$name";
        });
    }

    /**
     * @dataProvider resourceNameClassProvider
     */
    public function testResourceFindCallsCorrectEndpoint($name): void
    {
        Http::fake();

        $id = rand(1, 1000);

        $this->wordpress->$name->find($id);

        Http::assertSent(function (Request $request) use ($name, $id) {
            return $request->url() === "https://example.com/wp-json/wp/v2/$name/$id";
        });
    }

    public function resourceNameClassProvider(): array
    {
        return [
            ['categories', Categories::class, ],
            ['comments', Comments::class, ],
            ['media', Media::class, ],
            ['pages', Pages::class, ],
            ['posts', Posts::class, ],
            ['users', Users::class, ],
        ];
    }
}
