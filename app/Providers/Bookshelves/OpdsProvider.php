<?php

namespace App\Providers\Bookshelves;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Route;
use Spatie\ArrayToXml\ArrayToXml;

class OpdsProvider
{
	public static function feed(object | array $data, string $endpoint, string $route)
	{
		$id = strtolower(config('app.name'));
		$date = new DateTime();
		$date = $date->format('Y-m-d H:i:s');

		$entries = [];
		if ($data instanceof Collection || 'array' === gettype($data)) {
			foreach ($data as $key => $entry) {
				if ('feed' === $endpoint) {
					$templateEntry = self::entry(
						key: $entry->key,
						title: $entry->title,
						content: $entry->content,
						route: route($entry->route, ['version' => 'v1.2']),
						picture: config('app.url') . "/storage/assets/$entry->key.png"
					);
				} else {
					$templateEntry = self::entry(
						key: "$endpoint:$entry->slug",
						title: $entry->title ?? "$entry->lastname $entry->firstname",
						content: ucfirst($endpoint),
						route: $entry->show_link_opds,
						picture: $entry->image_thumbnail
					);
				}

				array_push($entries, $templateEntry);
			}
		} elseif ($data instanceof Model) {
			$templateEntry = self::entry(
				key: "$endpoint:$data->slug",
				title: $data->title ?? "$data->lastname $data->firstname",
				content: ucfirst($endpoint),
				route: $data->show_link_opds,
				picture: $data->image_thumbnail
			);

			array_push($entries, $templateEntry);
		}

		return $entries;
	}

	public static function template(object | array $data, string $endpoint, string $route)
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
					'href' => $route,
					'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
					'title' => 'Home',
				],
			],
			'__custom:link:2' => [
				'_attributes' => [
					'rel' => 'start',
					'href' => route('api.opds', ['version' => 'v1.2']),
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
			'entry' => OpdsProvider::feed(endpoint: $endpoint, data: $data, route: $route),
		], [
			'rootElementName' => 'feed',
			'_attributes' => $feed_links,
		], true, 'UTF-8');

		return $template;
	}

	public static function entry(string $key, string $title, string $content, string $route, string $picture)
	{
		$app = strtolower(config('app.name'));
		$date = new DateTime();
		$date = $date->format('Y-m-d H:i:s');

		$template = [
			'title' => $title,
			'updated' => $date,
			'id' => $app . ':' . $key,
			'content' => [
				'_attributes' => [
					'type' => 'text',
				],
				'_value' => $content,
			],
			'__custom:link:1' => [
				'_attributes' => [
					'href' => $route,
					'type' => 'application/atom+xml;profile=opds-catalog;kind=navigation',
				],
			],
			'__custom:link:2' => [
				'_attributes' => [
					'href' => $picture,
					'type' => 'image/png',
					'rel' => 'http://opds-spec.org/image/thumbnail',
				],
			],
		];

		return $template;
	}
}
