<?php declare(strict_types=1);

namespace Circli\HtmlTemplate;

interface RenderInterface
{
	/**
	 * @param array<string, mixed> $data
	 */
	public function render(string $tpl, array $data): string;
}
