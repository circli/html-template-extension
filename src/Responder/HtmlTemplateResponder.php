<?php declare(strict_types=1);

namespace Circli\HtmlTemplate\Responder;

use Circli\HtmlTemplate\RenderInterface;
use Circli\WebCore\DomainStatusToHttpStatus;
use PayloadInterop\DomainPayload;
use Polus\Adr\Interfaces\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class HtmlTemplateResponder implements Responder
{
	public const TEMPLATE = 'tpl';
	public const HTML = 'html';

	public function __construct(
		private RenderInterface $renderer,
	) {}

	public function __invoke(
		ServerRequestInterface $request,
		ResponseInterface $response,
		DomainPayload $payload
	): ResponseInterface {
		$responseCode = DomainStatusToHttpStatus::httpCode($payload);
		$response = $response->withStatus($responseCode);

		$html = '';
		$result = $payload->getResult();
		if (isset($result[self::HTML])) {
			$html = $result[self::HTML];
		}
		elseif (isset($result[self::TEMPLATE])) {
			$html = $this->renderer->render($result[self::TEMPLATE], $result);
		}

		$response = $response->withHeader('Content-Type', 'text/html');
		$response->getBody()->write($html);
		return $response;
	}
}
