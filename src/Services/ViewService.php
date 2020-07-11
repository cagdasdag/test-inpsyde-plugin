<?php

namespace TestInpsyde\Wp\Plugin\Services;

use TestInpsyde\Wp\Plugin\Traits\ConfigTrait;
use TestInpsyde\Wp\Plugin\Traits\ServiceTrait;
use TestInpsyde\Wp\Plugin\Traits\WPAttributeTrait;

class ViewService
{
    use ConfigTrait;
    use WPAttributeTrait;
    use ServiceTrait;

    public $basePath;
    public $baseUrl;

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->basePath = $this->getContainer()->basePath;
        $this->baseUrl  = $this->getContainer()->baseUrl;
    }

    /**
     * @param $viewFilePath
     * @param array $params
     *
     * @return string|void|null
     */
    public function render($viewFilePath, $params = [])
    {
        $extension = '.php';
        // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
        extract($params);
        if (strpos($viewFilePath, '/') === 1) {
            return load_template($viewFilePath, false);
        } elseif (! empty($template_content = locate_template($viewFilePath.$extension, true, false))) {
            return $template_content;
        } elseif (file_exists($this->basePath.DIRECTORY_SEPARATOR.$viewFilePath.$extension)) {
            return load_template($this->basePath.DIRECTORY_SEPARATOR.$viewFilePath.$extension, false);
        }

        $errorMessage = sprintf(
            "View file not working: %s.\nTrace: %s",
            $viewFilePath.$extension,
            print_r(debug_backtrace(), true)
        );
        // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
        trigger_error($errorMessage, E_USER_WARNING);

        return null;
    }
}
