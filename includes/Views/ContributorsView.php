<?php
namespace WPCG\Views;

/**
 * Contributors View Class
 *
 * Main view class for handling the contributors display logic.
 */
class ContributorsView {

    /**
     * Template Renderer instance
     *
     * @var TemplateRenderer
     */
    private $template_renderer;

    /**
     * Data Formatter instance
     *
     * @var ContributorsDataFormatter
     */
    private $data_formatter;

    /**
     * Constructor
     */
    public function __construct() {
        $this->template_renderer = new TemplateRenderer();
        $this->data_formatter = new ContributorsDataFormatter();
    }

    /**
     * Render contributors list
     *
     * @param array   $data             Contributors data.
     * @param boolean $version_switcher Whether to show version switcher.
     * @return string
     */
    public function render($data, $version_switcher = true) {
        if (empty($data) || !isset($data['groups'])) {
            return $this->template_renderer->render_error_message();
        }

        $view_data = $this->data_formatter->prepare_template_data($data, $version_switcher);
        return $this->template_renderer->render_template('contributors-list', $view_data);
    }

    /**
     * Include a template partial
     *
     * @param string $partial Partial template name.
     * @param array  $data Data to pass to partial.
     * @return void
     */
    public function get_template_partial($partial, $data) {
        $this->template_renderer->get_template_partial($partial, $data);
    }
}
