<?php
/**
 * Custom widgets for Iran News theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Popular Posts Widget
 */
class Iran_News_Popular_Posts_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'iran_news_popular_posts',
			__( 'ایران نیوز - پربازدیدترین‌ها', 'iran' ),
			array( 'description' => __( 'نمایش لیست مطالب پربازدید با تصویر شاخص', 'iran' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'پربازدیدترین‌ها', 'iran' );
		$count = ! empty( $instance['count'] ) ? $instance['count'] : 5;

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$popular_query = new WP_Query( array(
			'posts_per_page' => $count,
			'orderby'        => 'comment_count', // Simplified popularity
			'post_status'    => 'publish',
		) );

		if ( $popular_query->have_posts() ) :
			echo '<div class="divide-y divide-gray-200 dark:divide-gray-700">';
			while ( $popular_query->have_posts() ) : $popular_query->the_post();
				?>
				<a href="<?php the_permalink(); ?>" class="group block py-4 first:pt-0 last:pb-0 transition-colors">
					<div class="flex items-center gap-5 sm:gap-6 text-right">
						<div class="post-thumb-circle w-14 h-14 sm:w-16 sm:h-16 shrink-0 overflow-hidden rounded-full aspect-square">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'iran-square', array( 'class' => 'w-full h-full object-cover rounded-full group-hover:scale-110 transition-transform duration-500' ) ); ?>
							<?php else : ?>
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover rounded-full group-hover:scale-110 transition-transform duration-500">
							<?php endif; ?>
						</div>
						<div class="flex-1 min-w-0 pr-1">
							<h3 class="text-xs sm:text-sm font-bold leading-snug text-gray-800 dark:text-gray-200 group-hover:text-brand transition-colors line-clamp-2">
								<?php the_title(); ?>
							</h3>
						</div>
					</div>
				</a>
				<?php
			endwhile;
			echo '</div>';
			wp_reset_postdata();
		endif;

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'پربازدیدترین‌ها', 'iran' );
		$count = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 5;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'عنوان:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php _e( 'تعداد نمایش:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $count ); ?>" size="3">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_kses_post( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? absint( $new_instance['count'] ) : 5;
		return $instance;
	}
}

/**
 * Latest Posts List Widget
 */
class Iran_News_Latest_Posts_List_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'iran_news_latest_posts_list',
			__( 'ایران نیوز - لیست آخرین اخبار', 'iran' ),
			array( 'description' => __( 'نمایش لیست آخرین اخبار با قابلیت انتخاب دسته بندی و نوع نمایش', 'iran' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title        = ! empty( $instance['title'] ) ? $instance['title'] : __( 'آخرین اخبار', 'iran' );
		$count        = ! empty( $instance['count'] ) ? $instance['count'] : 10;
		$category     = ! empty( $instance['category'] ) ? absint( $instance['category'] ) : 0;
		$display_type = ! empty( $instance['display_type'] ) ? $instance['display_type'] : 'list';

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$query_args = array(
			'posts_per_page' => $count,
			'post_status'    => 'publish',
		);

		if ( $category > 0 ) {
			$query_args['cat'] = $category;
		}

		$latest_query = new WP_Query( $query_args );

		if ( $latest_query->have_posts() ) :
			if ( 'card' === $display_type ) {
				echo '<div class="divide-y divide-gray-200 dark:divide-gray-700">';
				while ( $latest_query->have_posts() ) : $latest_query->the_post();
					?>
					<a href="<?php the_permalink(); ?>" class="group block py-3.5 first:pt-0 last:pb-0 transition-colors">
						<div class="flex items-center gap-4 sm:gap-5 text-right">
							<div class="post-thumb-circle w-14 h-14 shrink-0 overflow-hidden rounded-full aspect-square">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'iran-square', array( 'class' => 'w-full h-full object-cover rounded-full group-hover:scale-110 transition-transform duration-500' ) ); ?>
								<?php else : ?>
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover rounded-full group-hover:scale-110 transition-transform duration-500">
								<?php endif; ?>
							</div>
							<div class="flex-1 min-w-0 pr-1">
								<h3 class="text-xs sm:text-[13px] font-bold leading-snug group-hover:text-brand transition-colors line-clamp-2">
									<?php the_title(); ?>
								</h3>
							</div>
						</div>
					</a>
					<?php
				endwhile;
				echo '</div>';
			} else {
				echo '<div class="space-y-4">';
				while ( $latest_query->have_posts() ) : $latest_query->the_post();
					?>
					<a href="<?php the_permalink(); ?>" class="group flex items-start gap-2 py-1.5 last:pb-0">
						<span class="w-1.5 h-1.5 rounded-full bg-brand/30 group-hover:bg-brand mt-2 shrink-0 transition-colors"></span>
						<h4 class="text-[13px] font-normal text-gray-600 dark:text-gray-400 leading-relaxed group-hover:text-brand transition-colors">
							<?php the_title(); ?>
						</h4>
					</a>
					<?php
				endwhile;
				echo '</div>';
			}
			wp_reset_postdata();
		endif;

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title        = ! empty( $instance['title'] ) ? $instance['title'] : __( 'آخرین اخبار', 'iran' );
		$count        = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 10;
		$category     = ! empty( $instance['category'] ) ? absint( $instance['category'] ) : 0;
		$display_type = ! empty( $instance['display_type'] ) ? $instance['display_type'] : 'list';

		$categories = get_categories();
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'عنوان:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php _e( 'تعداد نمایش:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $count ); ?>" size="3">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php _e( 'انتخاب دسته بندی:' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">
				<option value="0" <?php selected( $category, 0 ); ?>><?php _e( 'همه دسته‌ها', 'iran' ); ?></option>
				<?php foreach ( $categories as $cat ) : ?>
					<option value="<?php echo esc_attr( $cat->term_id ); ?>" <?php selected( $category, $cat->term_id ); ?>><?php echo esc_html( $cat->name ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'display_type' ) ); ?>"><?php _e( 'نوع نمایش:' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'display_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_type' ) ); ?>">
				<option value="list" <?php selected( $display_type, 'list' ); ?>><?php _e( 'لیست متنی (با نقطه)', 'iran' ); ?></option>
				<option value="card" <?php selected( $display_type, 'card' ); ?>><?php _e( 'لیست تصویری (با بندانگشتی)', 'iran' ); ?></option>
			</select>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title']        = ( ! empty( $new_instance['title'] ) ) ? wp_kses_post( $new_instance['title'] ) : '';
		$instance['count']        = ( ! empty( $new_instance['count'] ) ) ? absint( $new_instance['count'] ) : 10;
		$instance['category']     = ( ! empty( $new_instance['category'] ) ) ? absint( $new_instance['category'] ) : 0;
		$instance['display_type'] = ( ! empty( $new_instance['display_type'] ) ) ? sanitize_key( $new_instance['display_type'] ) : 'list';
		return $instance;
	}
}

/**
 * Ad Widget
 */
class Iran_News_Ad_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'iran_news_ad',
			__( 'ایران نیوز - جایگاه تبلیغ', 'iran' ),
			array( 'description' => __( 'نمایش یک جایگاه تبلیغاتی با استایل قالب', 'iran' ) )
		);
	}

	public function widget( $args, $instance ) {
		$text = ! empty( $instance['text'] ) ? $instance['text'] : __( 'محل تبلیغات شما', 'iran' );
		$link = ! empty( $instance['link'] ) ? $instance['link'] : '#';

		echo $args['before_widget'];
		?>
		<div class="relative group overflow-hidden rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-800 aspect-[4/3] flex items-center justify-center bg-gray-50/50 dark:bg-gray-900/50">
			<a href="<?php echo esc_url( $link ); ?>" class="text-center block w-full h-full flex flex-col items-center justify-center">
				<i data-lucide="image" class="w-8 h-8 text-gray-300 mx-auto mb-2"></i>
				<span class="text-xs font-bold text-gray-400 uppercase tracking-widest"><?php echo esc_html( $text ); ?></span>
			</a>
		</div>
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$text = ! empty( $instance['text'] ) ? $instance['text'] : __( 'محل تبلیغات شما', 'iran' );
		$link = ! empty( $instance['link'] ) ? $instance['link'] : '#';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'متن تبلیغ:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php _e( 'لینک:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['text'] = ( ! empty( $new_instance['text'] ) ) ? sanitize_text_field( $new_instance['text'] ) : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? esc_url_raw( $new_instance['link'] ) : '#';
		return $instance;
	}
}

/**
 * Banner and HTML Ads Widget
 */
class Iran_News_Banner_HTML_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'iran_news_banner_html_ad',
			__( 'ایران نیوز - تبلیغات بنری و HTML', 'iran' ),
			array( 'description' => __( 'نمایش بنر تبلیغاتی، کد HTML یا اسکریپت تبلیغاتی در قالب', 'iran' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$image_url  = ! empty( $instance['image_url'] ) ? $instance['image_url'] : '';
		$link_url   = ! empty( $instance['link_url'] ) ? $instance['link_url'] : '';
		$alt_text   = ! empty( $instance['alt_text'] ) ? $instance['alt_text'] : __( 'بنر تبلیغاتی', 'iran' );
		$html_code  = ! empty( $instance['html_code'] ) ? $instance['html_code'] : '';
		$open_blank = ! empty( $instance['open_blank'] );

		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		if ( ! empty( $html_code ) ) {
			echo '<div class="ad-widget-html overflow-hidden rounded-2xl border border-gray-200 bg-white p-0 shadow-sm dark:border-gray-700 dark:bg-slate-900">';
			echo $html_code; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '</div>';
		} elseif ( ! empty( $image_url ) ) {
			$target_rel = $open_blank ? ' target="_blank" rel="noopener noreferrer sponsored"' : ' rel="sponsored"';
			$link_start = ! empty( $link_url ) ? '<a href="' . esc_url( $link_url ) . '" class="block group" ' . $target_rel . '>' : '<div class="block group">';
			$link_end   = ! empty( $link_url ) ? '</a>' : '</div>';

			echo $link_start; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
			<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition-all duration-300 group-hover:shadow-lg dark:border-gray-700 dark:bg-slate-900">
				<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $alt_text ); ?>" class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-[1.02]" loading="lazy">
			</div>
			<?php
			echo $link_end; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$image_url  = ! empty( $instance['image_url'] ) ? $instance['image_url'] : '';
		$link_url   = ! empty( $instance['link_url'] ) ? $instance['link_url'] : '';
		$alt_text   = ! empty( $instance['alt_text'] ) ? $instance['alt_text'] : __( 'بنر تبلیغاتی', 'iran' );
		$html_code  = ! empty( $instance['html_code'] ) ? $instance['html_code'] : '';
		$open_blank = ! empty( $instance['open_blank'] );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'عنوان ویجت:', 'iran' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>"><?php _e( 'آدرس تصویر بنر:', 'iran' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_url' ) ); ?>" type="url" value="<?php echo esc_attr( $image_url ); ?>" placeholder="https://example.com/banner.jpg">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'link_url' ) ); ?>"><?php _e( 'لینک بنر:', 'iran' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link_url' ) ); ?>" type="url" value="<?php echo esc_attr( $link_url ); ?>" placeholder="https://example.com">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'alt_text' ) ); ?>"><?php _e( 'متن جایگزین تصویر:', 'iran' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'alt_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'alt_text' ) ); ?>" type="text" value="<?php echo esc_attr( $alt_text ); ?>">
		</p>
		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'open_blank' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'open_blank' ) ); ?>" type="checkbox" value="1" <?php checked( $open_blank ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'open_blank' ) ); ?>"><?php _e( 'باز شدن لینک در تب جدید', 'iran' ); ?></label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'html_code' ) ); ?>"><?php _e( 'کد HTML / اسکریپت تبلیغاتی:', 'iran' ); ?></label>
			<textarea class="widefat" rows="8" id="<?php echo esc_attr( $this->get_field_id( 'html_code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'html_code' ) ); ?>" placeholder="<?php esc_attr_e( 'اگر این فیلد پر شود، به جای بنر تصویری نمایش داده می‌شود.', 'iran' ); ?>"><?php echo esc_textarea( $html_code ); ?></textarea>
		</p>
		<p style="color:#666;font-size:12px;">
			<?php _e( 'اولویت نمایش با کد HTML است. اگر این فیلد خالی باشد، بنر تصویری با لینک نمایش داده می‌شود.', 'iran' ); ?>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance               = array();
		$instance['title']      = ! empty( $new_instance['title'] ) ? wp_kses_post( $new_instance['title'] ) : '';
		$instance['image_url']  = ! empty( $new_instance['image_url'] ) ? esc_url_raw( $new_instance['image_url'] ) : '';
		$instance['link_url']   = ! empty( $new_instance['link_url'] ) ? esc_url_raw( $new_instance['link_url'] ) : '';
		$instance['alt_text']   = ! empty( $new_instance['alt_text'] ) ? sanitize_text_field( $new_instance['alt_text'] ) : '';
		$instance['open_blank'] = ! empty( $new_instance['open_blank'] ) ? 1 : 0;

		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['html_code'] = ! empty( $new_instance['html_code'] ) ? $new_instance['html_code'] : '';
		} else {
			$instance['html_code'] = ! empty( $new_instance['html_code'] ) ? wp_kses_post( $new_instance['html_code'] ) : '';
		}

		return $instance;
	}
}

/**
 * Register all widgets
 */
function iran_news_register_widgets() {
	register_widget( 'Iran_News_Popular_Posts_Widget' );
	register_widget( 'Iran_News_Latest_Posts_List_Widget' );
	register_widget( 'Iran_News_Ad_Widget' );
	register_widget( 'Iran_News_Banner_HTML_Widget' );
}
add_action( 'widgets_init', 'iran_news_register_widgets' );
