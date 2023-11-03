<?php

namespace RickWest\WordPress\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use RickWest\WordPress\Facades\WordPress as WordPressFacade;
use RickWest\WordPress\Resources\Categories;
use RickWest\WordPress\Resources\Comments;
use RickWest\WordPress\Resources\Media;
use RickWest\WordPress\Resources\Pages;
use RickWest\WordPress\Resources\Posts;
use RickWest\WordPress\Resources\Resource;
use RickWest\WordPress\Resources\Users;
use RickWest\WordPress\Resources\Plugins;
use RickWest\WordPress\WordPress;

class WordPressTest extends TestCase
{
    public WordPress $wordpress;

    public function setUp(): void
    {
        parent::setUp();

        Config::set('wordpress-api.url', 'https://example.com');

        $this->wordpress = app(WordPress::class);
    }

    public function testCanBeInstantiated(): void
    {
        $this->assertInstanceOf(WordPress::class, new WordPress());
    }

    public function testFacadeReturnsInstanceOfWordPress(): void
    {
        $this->assertInstanceOf(WordPress::class, WordPressFacade::getFacadeRoot());
    }

    public function testHelperReturnsInstanceOfWordPress(): void
    {
        $this->assertInstanceOf(WordPress::class, wordpress());
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
            ['plugins', Plugins::class, ],
        ];
    }
}
