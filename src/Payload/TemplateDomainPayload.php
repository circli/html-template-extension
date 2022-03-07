<?php declare(strict_types=1);

namespace Circli\HtmlTemplate\Payload;

use Circli\HtmlTemplate\Responder\HtmlTemplateResponder;
use PayloadInterop\DomainPayload;

final class TemplateDomainPayload implements DomainPayload
{
	/**
	 * @param array<string, mixed> $data
	 */
	public function __construct(
		private string $status,
		private string $template,
		private array $data = [],
	) {}

	public function getStatus(): string
	{
		return $this->status;
	}

	/**
	 * @return array<string, mixed>
	 */
	public function getResult(): array
	{
		$this->data[HtmlTemplateResponder::TEMPLATE] = $this->template;
		return $this->data;
	}
}
