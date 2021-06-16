<?php

namespace App\Providers\Bookshelves;

use DateTime;
use File;
use Route;
use Spatie\ArrayToXml\ArrayToXml;

class OpdsProvider
{
	public static function feed()
	{
		$id = strtolower(config('app.name'));
		$date = new DateTime();
		$date = $date->format('Y-m-d H:i:s');

		$feed = [
			[
				'title' => 'Authors',
				'updated' => $date,
				'id' => "$id:authors",
				'content' => [
					'_attributes' => [
						'type' => 'text',
					],
				],
				'__custom:link:1' => [
					'_attributes' => [
						'href' => '',
						'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
					],
				],
				'__custom:link:2' => [
					'_attributes' => [
						'href' => 'image-path',
						'type' => 'image/png',
						'rel' => 'http://opds-spec.org/image/thumbnail',
					],
				],
			],
			[
				'title' => 'Series',
				'updated' => $date,
				'id' => "$id:series",
				'content' => [
					'_attributes' => [
						'type' => 'text',
					],
				],
				'__custom:link:1' => [
					'_attributes' => [
						'href' => route(Route::currentRouteName()),
						'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
					],
				],
				'__custom:link:2' => [
					'_attributes' => [
						'href' => 'image-path',
						'type' => 'image/png',
						'rel' => 'http://opds-spec.org/image/thumbnail',
					],
				],
			],
			[
				'title' => 'Publishers',
				'updated' => $date,
				'id' => "$id:publishers",
				'content' => [
					'_attributes' => [
						'type' => 'text',
					],
				],
				'__custom:link:1' => [
					'_attributes' => [
						'href' => route(Route::currentRouteName()),
						'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
					],
				],
				'__custom:link:2' => [
					'_attributes' => [
						'href' => 'image-path',
						'type' => 'image/png',
						'rel' => 'http://opds-spec.org/image/thumbnail',
					],
				],
			],
		];

		$entries = [];
		$feed = File::get(app_path('Providers/Bookshelves/Feed/opds.json'));
		$feed = json_decode($feed);
		$template = [
			'title' => 'Title',
			'updated' => $date,
			'id' => '',
			'content' => [
				'_attributes' => [
					'type' => 'text',
				],
				'_value' => '',
			],
			'__custom:link:1' => [
				'_attributes' => [
					'href' => '',
					'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
				],
			],
			'__custom:link:2' => [
				'_attributes' => [
					'href' => '',
					'type' => 'image/png',
					'rel' => 'http://opds-spec.org/image/thumbnail',
				],
			],
		];

		foreach ($feed as $key => $entry) {
			$templateEntry = $template;
			$templateEntry['title'] = $entry->title;
			$templateEntry['id'] = $id . ':' . $entry->key;
			$templateEntry['content']['_value'] = $entry->content;
			$templateEntry['__custom:link:1']['_attributes']['href'] = route($entry->route);
			$templateEntry['__custom:link:2']['_attributes']['href'] = config('app.url') . "/storage/assets/$entry->key.png";
			array_push($entries, $templateEntry);
		}

		return $entries;
	}

	public static function template()
	{
		$date = new DateTime();
		$date = $date->format('Y-m-d H:i:s');

		$feed_links = [
			'xmlns:app' => 'http://www.w3.org/2007/app',
			'xmlns:opds' => 'http://opds-spec.org/2010/catalog',
			'xmlns:opensearch' => 'http://a9.com/-/spec/opensearch/1.1/',
			'xmlns:odl' => 'http://opds-spec.org/odl',
			'xmlns:dcterms' => 'http://purl.org/dc/terms/',
			'xmlns' => 'http://www.w3.org/2005/Atom',
			'xmlns:thr' => 'http://purl.org/syndication/thread/1.0',
			'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
		];
		$template = ArrayToXml::convert([
			'id' => config('app.name') . ':catalog',
			'__custom:link:1' => [
				'_attributes' => [
					'rel' => 'self',
					'href' => route(Route::currentRouteName()),
					'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
					'title' => 'Home',
				],
			],
			'__custom:link:2' => [
				'_attributes' => [
					'rel' => 'start',
					'href' => route('api.opds.1-2'),
					'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
					'title' => 'Feed',
				],
			],
			'title' => config('app.name') . ' OPDS',
			'updated' => $date,
			'author' => [
				'name' => config('app.name'),
				'uri' => config('app.url'),
			],
			'entry' => OpdsProvider::feed(),
		], [
			'rootElementName' => 'feed',
			'_attributes' => $feed_links,
		], true, 'UTF-8');

		return $template;
	}
}
