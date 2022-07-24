<?php

use Google\CloudFunctions\FunctionsFramework;
use Psr\Http\Message\ServerRequestInterface;

FunctionsFramework::http('main', 'helloHttp');

function helloHttp(ServerRequestInterface $request): string
{
	$name = 'World';
	$body = $request->getBody()->getContents();
	if (!empty($body)) {
		$json = json_decode($body, true);
		if (json_last_error() != JSON_ERROR_NONE) {
			throw new RuntimeException(sprintf(
				'Could not parse body: %s',
				json_last_error_msg()
			));
		}
		$name = $json['name'] ?? $name;
	}
	$queryString = $request->getQueryParams();
	$name = $queryString['name'] ?? $name;

	return sprintf('Hello, %s!', htmlspecialchars($name));
}