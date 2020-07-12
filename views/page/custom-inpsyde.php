<?php
/**
 * The Template for displaying data from https://jsonplaceholder.typicode.com/users)
 */

use TestInpsyde\Wp\Plugin\TestInpsyde;

// phpcs:ignore PSR2.ControlStructures.ControlStructureSpacing.SpacingAfterOpenBrace
if ( ! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/** @noinspection PhpUnhandledExceptionInspection */
$viewService = TestInpsyde::getServiceView();
$textDomain  = $viewParams['textDomain'] ?? 'inpsyde';
$users       = $viewParams['users'] ?? [];

get_header();
?>

<main id="site-content" role="main">
    <article class="custom-page">
        <header class="entry-header custom-page__header">
            <div class="entry-header-inner">
                <h1 class="entry-title"><?php echo esc_html(__('Custom Inpsyde', $textDomain)) ?></h1>
            </div><!-- .archive-header-inner -->
        </header>
        <div class="post-inner custom-page__content">
            <div class="entry-content">

                <?php
                if ( ! empty($users)) {
                    ?>
                    <table class="custom-page__grid">
                        <tr class="custom-page__grid__row">
                            <th class="custom-page__grid__order-number"><?php echo '#' ?></th>
                            <th class="custom-page__grid__id"><?php echo esc_html(__('ID', $textDomain)) ?></th>
                            <th class="custom-page__grid__name"><?php echo esc_html(__('Name', $textDomain)) ?></th>
                            <th class="custom-page__grid__username"><?php echo esc_html(__('Username',
                                    $textDomain)) ?></th>
                        </tr>
                        <?php
                        foreach ($users as $tmpIndex => $user) {
                            $ajaxHtmlUrl = add_query_arg([
                                'action' => 'get_single_user',
                                'id'         => $user['id'],
                            ], admin_url('admin-ajax.php'));
                            ?>
                            <tr class="custom-page__grid__row">
                                <td class="custom-page__grid__order-number"><?php echo $tmpIndex + 1 ?></td>
                                <td class="custom-page__grid__id"><a href="javascript:" data-ajax-html-enabled="true"
                                                                     data-ajax-html-url="<?php echo esc_attr($ajaxHtmlUrl) ?>"><?php echo esc_html($user['id']) ?></a>
                                </td>
                                <td class="custom-page__grid__name"><a href="javascript:" data-ajax-html-enabled="true"
                                                                       data-ajax-html-url="<?php echo esc_attr($ajaxHtmlUrl) ?>"><?php echo esc_html($user['name']) ?></a>
                                </td>
                                <td class="custom-page__grid__username"><a href="javascript:"
                                                                           data-ajax-html-enabled="true"
                                                                           data-ajax-html-url="<?php echo esc_attr($ajaxHtmlUrl) ?>"><?php echo esc_html($user['username']) ?></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                    <?php
                }
                ?>

            </div>
        </div>
    </article>
</main>

<?php
get_footer();
?>