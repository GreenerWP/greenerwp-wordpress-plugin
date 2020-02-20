<?php
namespace GreenerWP\UI\Admin;

/**
 * Main admin page of GreenerWP.
 */
class Page {
  private $frontend = null;
  private $template_renderer = null;

	const MENU_ICON = 'data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgNDMuNyA0Ni4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIGQ9Im0yMi45LjkxLS4wMTE3IDEzLjhjMS4wMy4wMzMgMi4wOC4yMTEgMy4xNS41NDMgMS4xOS4zNzcgMi4xNy45MTMgMi45NyAxLjYybDcuOTctMTEuM2MtLjk2Ny0uODM1LTIuMTgtMS42LTMuNjItMi4zMS0xLjIzLS42MTMtMi43NS0xLjE2LTQuNTUtMS42NS0xLjY4LS40NDctMy42Ni0uNjgzLTUuOTEtLjcxM3ptLTEgLjAzOTFjLTIuOTYuMDYtNS43NS42NjEtOC4zNCAxLjgtMi42MSAxLjE0LTQuODcgMi42OS02LjggNC42Mmw5Ljc5IDkuODRjLjcyLS43MSAxLjU2LTEuMjggMi41MS0xLjcuODgtLjM4IDEuODItLjU5NSAyLjg0LS42NmwuMDAxOTUtMTMuOXptLTE1LjggNy4xYy0xLjgyIDItMy4yNyA0LjMxLTQuMzQgNi45NC0xLjA1IDIuNTgtMS42IDUuMzEtMS42OSA4LjE4aDEzLjhjLjA3MS0xLjAyLjI3Ni0xLjk5LjYyOS0yLjkuMzQ2LS45MDguODA0LTEuNyAxLjM2LTIuNDFsLTkuOC05Ljgxem0xNi42IDEyLjdjLTEuMDcgMC0xLjk0Ljg2OS0xLjk0IDEuOTRzLjg2OCAxLjk0IDEuOTQgMS45NGMxLjA3LjAwMyAyMS4xLTEuNTIgMjEuMS0xLjk0LjAwMS0uMzE4LTIwLTEuOTQtMjEuMS0xLjk0em0uMTI1Ljg1OWMuNTk2LS4wMDEgMS4wOC40ODQgMS4wOCAxLjA4LS4wMDQuNTk3LS40ODkgMS4wOC0xLjA4IDEuMDgtLjU5OS4wMDItMS4wOC0uNDg0LTEuMDgtMS4wOC0uMDAxLS41OTcuNDgzLTEuMDggMS4wOC0xLjA4em0tMjIuNyAyLjUxYy4wMjcgMy4xNy42MjkgNi4xMyAxLjgxIDguODcgMS4wNCAyLjQxIDIuNCA0LjU1IDQuMDggNi40MWw5Ljc3LTkuODNjLS40NTUtLjU5OC0uODQtMS4yNS0xLjE1LTEuOTgtLjQ1NS0xLjA4LS42ODgtMi4yNC0uNzEzLTMuNDdoLTEzLjh6bTQzLjMuOTMtMTcuNSAxLjQ1LS4xNzggMy4wNyA0LjY0LjAwMzkxYy0uMTg5LjIzNy0uMzk1LjQ1Ny0uNi42NzRsOS43OSA5LjhjLjA1NS0uMDUzLjEwOS0uMTAyLjE2NC0uMTU2IDEuNC0xLjQ3IDIuNjEtMy4xMSAzLjYyLTQuOTFsLjA2MjUtOS45M3ptLTI2LjkgNS4yOS05Ljc5IDkuNzljLjA2LjA1Ny4xMTMuMTIxLjE3NC4xOCAyLjA5IDIuMDcgNC41NCAzLjY5IDcuMzUgNC44OCAyLjQ2IDEuMDQgNS4wNSAxLjYyIDcuNzggMS43NWwtLjAxMzctMTMuOWMtLjgzOC0uMS0xLjY0LS4yOTctMi40LS42MTMtMS4xMi0uNDYxLTIuMS0xLjEtMi45My0xLjkxLS4wNi0uMDU4LS4xMTUtLjEyNS0uMTcyLS4xODR6bTEyLjYuNTg4Yy0uNTYyLjQ3OC0xLjE3Ljg5Ni0xLjg0IDEuMjQtMS4yMy42MzgtMi41OS45NTUtNC4wOC45NTUtLjA2IDAtLjExOS0uMDA1ODYtLjE4Mi0uMDA1ODZsLjAwMTk1IDEzLjhjLjA1OSAwIC4xMi4wMDQ4Ni4xODIuMDA1ODYgMi4xNSAwIDQuMjQtLjI4NiA2LjI2LS44NTkgMi4wMi0uNTY5IDMuOS0xLjM4IDUuNjQtMi40NCAxLjM4LS44NDQgMi42Ni0xLjgyIDMuODQtMi45M2wtOS44Mi05Ljc3eiIgZmlsbD0icmdiYSgyNDAsMjQ1LDI1MCwuNikiLz48L3N2Zz4K';

	public function __construct( $frontend, $template_renderer ) {
    $this->frontend = $frontend;
    $this->template_renderer = $template_renderer;
	}

	public function run() {
		add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
    $this->frontend->enqueue_admin_script(
      'greenerwp-ui-admin-page', 'ui/admin/page.js',
      [ 'wp-i18n', 'wp-api', 'wp-components', 'wp-element', 'wp-data', 'wp-redux-routine' ] );
    $this->frontend->enqueue_admin_style(
      'greenerwp-ui-admin', 'admin.css', [ 'wp-components' ] );
  }

  public function add_admin_menu() {
    add_menu_page( __( 'GreenerWP', 'greenerwp' ), __( 'GreenerWP', 'greenerwp' ), 'manage_options', 'greenerwp', [ $this, 'render' ], self::MENU_ICON );
  }

  public function render() {
    $this->template_renderer->render( 'admin/page', [] );
  }
}
