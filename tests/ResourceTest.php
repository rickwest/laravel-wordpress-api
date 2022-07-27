<?php

namespace RickWest\Wordpress\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;
use RickWest\Wordpress\Client;
use RickWest\Wordpress\Resources\Resource as BaseResource;
use RickWest\Wordpress\Resources\Traits\HasAuthor;
use RickWest\Wordpress\Resources\Traits\HasDate;
use RickWest\Wordpress\Resources\Traits\HasSlug;

class ResourceTest extends TestCase
{
    private Resource $resource;

    public function setUp(): void
    {
        parent::setUp();

        $this->resource = new Resource(
            new Client('https://example.com')
        );

        Http::fake([
            'https://example.com/wp-json/wp/v2/resource/999' => Http::response(null, 404),
            'https://example.com/wp-json/wp/v2/resource/*' => Http::response(
                [
                    'title' => 'My title',
                ]
            ),
            'https://example.com/wp-json/wp/v2/resource?page=999' => Http::response(null, 400),
            'https://example.com/wp-json/wp/v2/resource' => Http::response(
                [
                    ['title' => 'My first title'],
                    ['title' => 'My second title'],
                    ['title' => 'My third title'],
                ],
                200,
                [
                    'X-WP-TotalPages' => 1,
                    'X-WP-Total' => 3,
                ]
            ),
            '*' => Http::response(),
        ]);
    }

    public function testEmbedAddsDefaultQueryParameter(): void
    {
        $this->resource->embed()->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource?_embed=1";
        });
    }

    public function testEmbedAddsQueryParameter(): void
    {
        $this->resource->embed('relation')->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource?_embed=relation";
        });
    }

    public function testEmbedAddsMultipleQueryParameters(): void
    {
        $this->resource->embed(['relation1', 'relation2'])->get();

        Http::assertSent(function (Request $request) {
            return urldecode($request->url()) === "https://example.com/wp-json/wp/v2/resource?_embed[0]=relation1&_embed[1]=relation2";
        });
    }

    public function testWithAddsQueryParameter(): void
    {
        $this->resource->with('relation')->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource?_embed=relation";
        });
    }

    public function testWithAddsMultipleQueryParameters(): void
    {
        $this->resource->with(['relation1', 'relation2'])->get();

        Http::assertSent(function (Request $request) {
            return urldecode($request->url()) === "https://example.com/wp-json/wp/v2/resource?_embed[0]=relation1&_embed[1]=relation2";
        });
    }

    public function testFieldsAddsQueryParameter(): void
    {
        $this->resource->fields('title')->get();

        Http::assertSent(function (Request $request) {
            return urldecode($request->url()) === "https://example.com/wp-json/wp/v2/resource?_fields=title";
        });
    }

    public function testFieldsAddsMultipleQueryParameters(): void
    {
        $this->resource->fields(['field1', 'field2'])->get();

        Http::assertSent(function (Request $request) {
            return urldecode($request->url()) === "https://example.com/wp-json/wp/v2/resource?_fields[0]=field1&_fields[1]=field2";
        });
    }

    public function testPageAddsQueryParameter(): void
    {
        $this->resource->page(6)->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource?page=6";
        });
    }

    public function testPerPageAddsQueryParameter(): void
    {
        $this->resource->perPage(25)->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource?per_page=25";
        });
    }

    public function testOffsetAddsQueryParameter(): void
    {
        $this->resource->offset(2)->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource?offset=2";
        });
    }

    public function testSearchAddsQueryParameter(): void
    {
        $this->resource->search('term')->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource?search=term";
        });
    }

    public function testExcludeAddsQueryParameter(): void
    {
        $this->resource->exclude(6)->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource?exclude=6";
        });
    }

    public function testExcludeAddsMultipleQueryParameters(): void
    {
        $this->resource->exclude([6, 12, 18])->get();

        Http::assertSent(function (Request $request) {
            return urldecode($request->url()) === "https://example.com/wp-json/wp/v2/resource?exclude[0]=6&exclude[1]=12&exclude[2]=18";
        });
    }

    public function testIncludeAddsQueryParameter(): void
    {
        $this->resource->include(6)->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource?include=6";
        });
    }

    public function testIncludeAddsMultipleQueryParameters(): void
    {
        $this->resource->include([6, 12, 18])->get();

        Http::assertSent(function (Request $request) {
            return urldecode($request->url()) === "https://example.com/wp-json/wp/v2/resource?include[0]=6&include[1]=12&include[2]=18";
        });
    }

    public function testOrderByAddsQueryParameters(): void
    {
        $this->resource->orderBy('field', 'asc')->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource?orderby=field&order=asc";
        });
    }

    public function testAuthorAddsQueryParameter(): void
    {
        $this->resource->author(6)->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource?author=6";
        });
    }

    public function testAuthorAddsMultipleQueryParameters(): void
    {
        $this->resource->author([6, 12, 18])->get();

        Http::assertSent(function (Request $request) {
            return urldecode($request->url()) === "https://example.com/wp-json/wp/v2/resource?author[0]=6&author[1]=12&author[2]=18";
        });
    }

    public function testAuthorExcludeAddsQueryParameter(): void
    {
        $this->resource->authorExclude(6)->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource?author_exclude=6";
        });
    }

    public function testAuthorExcludeAddsMultipleQueryParameters(): void
    {
        $this->resource->authorExclude([6, 12, 18])->get();

        Http::assertSent(function (Request $request) {
            return urldecode($request->url()) === "https://example.com/wp-json/wp/v2/resource?author_exclude[0]=6&author_exclude[1]=12&author_exclude[2]=18";
        });
    }

    public function testSlugAddsQueryParameter(): void
    {
        $this->resource->slug('slug')->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource?slug=slug";
        });
    }

    public function testOldestAddsQueryParameters(): void
    {
        $this->resource->oldest()->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource?orderby=date&order=asc";
        });
    }

    public function testLatestAddsQueryParameters(): void
    {
        $this->resource->latest()->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource?orderby=date&order=desc";
        });
    }

    public function testBeforeAddsQueryParameter(): void
    {
        $this->resource->before(Date::create(2013, 7, 6))->get();

        Http::assertSent(function (Request $request) {
            return urldecode($request->url()) === "https://example.com/wp-json/wp/v2/resource?before=2013-07-06T00:00:00+00:00";
        });
    }

    public function testAfterAddsQueryParameter(): void
    {
        $this->resource->after(Date::create(2013, 7, 6))->get();

        Http::assertSent(function (Request $request) {
            return urldecode($request->url()) === "https://example.com/wp-json/wp/v2/resource?after=2013-07-06T00:00:00+00:00";
        });
    }

    public function testWhenConditionTrueAddsQueryParameter(): void
    {
        $this->resource->when(true, fn ($query) => $query->parameter('param', 'value'))->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource?param=value";
        });
    }

    public function testWhenConditionFalseDoesNotAddQueryParameter(): void
    {
        $this->resource->when(false, fn ($query) => $query->parameter('param', 'value'))->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource";
        });
    }

    public function testFindCallsCorrectEndpoint(): void
    {
        $this->resource->find(123);

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource/123";
        });
    }

    public function testFindOnlyBuildsQueryWithGlobalParameters(): void
    {
        $this->resource->parameter('not', 'allowed')->embed()->find(123, ['custom' => 'param']);

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource/123?_embed=1&custom=param";
        });
    }

    public function testFindReturnsNullOnFailure(): void
    {
        $this->assertNull($this->resource->find(999));
    }

    public function testFindReturnsDataOnSuccess(): void
    {
        $this->assertEquals(['title' => 'My title'], $this->resource->find(123));
    }

    public function testGetCallsCorrectEndpoint(): void
    {
        $this->resource->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === "https://example.com/wp-json/wp/v2/resource";
        });
    }

    public function testGetBuildsCorrectQuery(): void
    {
        $this->resource->latest()
            ->search('term')
            ->fields(['title', 'content'])
            ->embed()
            ->get();

        Http::assertSent(function (Request $request) {
            return urldecode($request->url()) === "https://example.com/wp-json/wp/v2/resource?orderby=date&order=desc&search=term&_fields[0]=title&_fields[1]=content&_embed=1";
        });
    }

    public function testGetReturnsEmptyOnFailure(): void
    {
        $this->assertEquals(
            [
                'data' => [],
                'meta' => [
                    'pages' => 0,
                    'total' => 0,
                ],
            ],
            $this->resource->page(999)->get()
        );
    }

    public function testGetReturnsDataOnSuccess(): void
    {
        $this->assertEquals(
            [
                'data' => [
                    ['title' => 'My first title'],
                    ['title' => 'My second title'],
                    ['title' => 'My third title'],
                ],
                'meta' => [
                    'pages' => 1,
                    'total' => 3,
                ],
            ],
            $this->resource->get()
        );
    }

    public function testSendCustomRequest(): void
    {
        $this->resource->send('POST', 45, [
            'json' => ['title' => 'My New Title'],
        ]);

        Http::assertSent(function (Request $request) {
            return $request->method() === 'POST'
               && $request->url() === "https://example.com/wp-json/wp/v2/resource/45"
               && $request->isJson()
               && $request->data() === ['title' => 'My New Title'];
        });
    }
}

class Resource extends BaseResource
{
    use HasSlug;
    use HasDate;
    use HasAuthor;
}
