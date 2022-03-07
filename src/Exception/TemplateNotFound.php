<?php declare(strict_types=1);

namespace Circli\HtmlTemplate\Exception;

final class TemplateNotFound extends \DomainException
{
	public static function fileNotFound(string $file): self
	{
		return new static(sprintf('Template file not found: %s', $file));
	}
}
