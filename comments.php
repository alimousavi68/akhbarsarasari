<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Iran_News
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area mt-12 space-y-6">

    <!-- Comments List Accordion -->
    <div class="comments-list-section bg-gray-50 dark:bg-gray-900 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800">
        <button class="w-full flex items-center justify-between p-5 text-right transition-colors hover:bg-gray-100 dark:hover:bg-gray-800 accordion-toggle" data-target="comments-list-content">
            <div class="flex items-center gap-3">
                <i data-lucide="message-square" class="w-5 h-5 text-brand"></i>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    <?php
                    $comments_number = get_comments_number();
                    if ( '1' === $comments_number ) {
                        printf( _x( 'یک دیدگاه', 'comments title', 'iran' ) );
                    } else {
                        printf(
                            /* translators: 1: number of comments, 2: post title */
                            _nx(
                                '%1$s دیدگاه',
                                '%1$s دیدگاه',
                                $comments_number,
                                'comments title',
                                'iran'
                            ),
                            number_format_i18n( $comments_number )
                        );
                    }
                    ?>
                </h3>
            </div>
            <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform duration-300 transform"></i>
        </button>

        <div id="comments-list-content" class="accordion-content hidden px-5 pb-5">
            <?php if ( have_comments() ) : ?>
                <ul class="comment-list divide-y divide-gray-100 dark:divide-gray-800">
                    <?php
                    wp_list_comments(
                        array(
                            'style'      => 'ul',
                            'short_ping' => true,
                            'avatar_size' => 48,
                            'callback'   => 'iran_news_comment_callback'
                        )
                    );
                    ?>
                </ul>

                <?php
                the_comments_navigation( array(
                    'prev_text' => '<i data-lucide="chevron-right" class="w-4 h-4"></i> ' . __( 'دیدگاه‌های قبلی', 'iran' ),
                    'next_text' => __( 'دیدگاه‌های بعدی', 'iran' ) . ' <i data-lucide="chevron-left" class="w-4 h-4"></i>',
                    'class'     => 'flex justify-between mt-8 pt-6 border-t border-gray-100 dark:border-gray-800 text-sm font-medium'
                ) );
                ?>

            <?php endif; ?>

            <?php if ( ! comments_open() ) : ?>
                <p class="no-comments text-center py-4 text-gray-500 text-sm"><?php esc_html_e( 'امکان ثبت دیدگاه برای این مطلب بسته شده است.', 'iran' ); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Comment Form Accordion -->
    <?php if ( comments_open() ) : ?>
        <div class="comment-form-section bg-white dark:bg-gray-900 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 shadow-sm">
            <button class="w-full flex items-center justify-between p-5 text-right transition-colors hover:bg-gray-50 dark:hover:bg-gray-800 accordion-toggle" data-target="comment-form-content">
                <div class="flex items-center gap-3">
                    <i data-lucide="pen-tool" class="w-5 h-5 text-brand"></i>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white"><?php _e( 'ارسال دیدگاه جدید', 'iran' ); ?></h3>
                </div>
                <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform duration-300 transform"></i>
            </button>

            <div id="comment-form-content" class="accordion-content hidden px-5 pb-5">
                <?php
                $commenter = wp_get_current_commenter();
                $req       = get_option( 'require_name_email' );
                $aria_req  = ( $req ? " aria-required='true'" : '' );

                $fields = array(
                    'author' => '<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . __( 'نام شما (الزامی)', 'iran' ) . '" class="w-full bg-gray-50 dark:bg-black border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm focus:border-brand focus:ring-1 focus:ring-brand outline-none transition-all" ' . $aria_req . '>
                                    </div>',
                    'email'  => '   <div>
                                        <input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="' . __( 'ایمیل شما (الزامی - منتشر نمی‌شود)', 'iran' ) . '" class="w-full bg-gray-50 dark:bg-black border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm focus:border-brand focus:ring-1 focus:ring-brand outline-none transition-all" ' . $aria_req . '>
                                    </div>
                                </div>',
                );

                $comment_field = '<div class="mb-4">
                                    <textarea id="comment" name="comment" rows="4" placeholder="' . __( 'متن دیدگاه شما...', 'iran' ) . '" class="w-full bg-gray-50 dark:bg-black border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm focus:border-brand focus:ring-1 focus:ring-brand outline-none transition-all" aria-required="true"></textarea>
                                 </div>';

                $must_log_in = '<p class="must-log-in text-sm text-gray-500 mb-4">' . sprintf( __( 'برای ارسال دیدگاه باید <a href="%s" class="text-brand">وارد شوید</a>.', 'iran' ), wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>';

                $logged_in_as = '<div class="logged-in-as flex items-center gap-3 mb-6 p-4 bg-brand/5 dark:bg-brand/10 rounded-xl border border-brand/10">
                                    <div class="w-10 h-10 rounded-full overflow-hidden shrink-0 border-2 border-white dark:border-gray-800 shadow-sm">
                                        ' . get_avatar( get_current_user_id(), 40 ) . '
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-700 dark:text-gray-300 leading-tight">
                                            ' . sprintf( __( 'وارد شده با نام <span class="font-bold text-gray-900 dark:text-white">%s</span>', 'iran' ), wp_get_current_user()->display_name ) . '
                                            <a href="' . wp_logout_url( get_permalink() ) . '" title="' . esc_attr__( 'خروج از حساب کاربری', 'iran' ) . '" class="text-xs text-brand mr-2 underline underline-offset-4">' . __( 'خروج؟', 'iran' ) . '</a>
                                        </p>
                                    </div>
                                </div>';

                comment_form( array(
                    'fields'               => $fields,
                    'comment_field'        => $comment_field,
                    'must_log_in'          => $must_log_in,
                    'logged_in_as'         => $logged_in_as,
                    'comment_notes_before' => '',
                    'class_form'           => 'comment-form',
                    'class_submit'         => 'submit-btn bg-brand text-white px-8 py-3 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-brand/20 transition-all cursor-pointer',
                    'label_submit'         => __( 'ثبت دیدگاه', 'iran' ),
                    'title_reply'          => '',
                    'title_reply_to'       => __( 'پاسخ به %s', 'iran' ),
                    'cancel_reply_link'    => __( 'لغو پاسخ', 'iran' ),
                    'id_submit'            => 'submit-comment',
                ) );
                ?>
            </div>
        </div>
    <?php endif; ?>

</div>
