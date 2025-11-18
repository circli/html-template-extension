<?php declare(strict_types=1);

namespace Circli\HtmlTemplate\Renderer;

use Circli\HtmlTemplate\Exception\TemplateNotFound;
use Circli\HtmlTemplate\RenderInterface;

final class PhpFileRenderer implements RenderInterface
{
	private string $templatePath;
	/** @var callable(string): string */
	private $pathResolve;

	/**
	 * @param null|callable(string): string $pathResolve
	 */
	public function __construct(string $templatePath, callable|null $pathResolve = null)
	{
		$this->templatePath = rtrim($templatePath, DIRECTORY_SEPARATOR);
		$this->pathResolve = $pathResolve ?? static fn (string $tpl) => $tpl;
	}

	public function render(string $tpl, array $data): string
	{
		extract($data, EXTR_SKIP);

		ob_start();
		include $this->resolvePath($tpl);
		return (string)ob_get_clean();
	}

	private function resolvePath(string $tpl): string
	{
		$tpl = ($this->pathResolve)($tpl);
		if (file_exists($tpl)) {
			return $tpl;
		}

		$tpl = $this->templatePath . DIRECTORY_SEPARATOR . $tpl . '.php';
		if (file_exists($tpl)) {
			return $tpl;
		}

		throw TemplateNotFound::fileNotFound($tpl);
	}
}
