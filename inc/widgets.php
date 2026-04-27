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
			echo '<div class="flex flex-col gap-6">';
			while ( $popular_query->have_posts() ) : $popular_query->the_post();
				?>
				<a href="<?php the_permalink(); ?>" class="group block py-4 border-b border-gray-100 dark:border-gray-800 last:border-0">
					<div class="flex items-center gap-4 text-right">
						<div class="w-24 h-16 shrink-0 overflow-hidden rounded-lg">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'iran-thumbnail', array( 'class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500' ) ); ?>
							<?php else : ?>
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="<?php the_title(); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
							<?php endif; ?>
						</div>
						<div class="flex-1">
							<h3 class="text-sm font-bold leading-snug group-hover:text-brand transition-colors line-clamp-2">
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
			array( 'description' => __( 'نمایش لیست متنی آخرین اخبار با استایل مینیمال', 'iran' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'آخرین اخبار', 'iran' );
		$count = ! empty( $instance['count'] ) ? $instance['count'] : 15;

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$latest_query = new WP_Query( array(
			'posts_per_page' => $count,
			'post_status'    => 'publish',
		) );

		if ( $latest_query->have_posts() ) :
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
			wp_reset_postdata();
		endif;

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'آخرین اخبار', 'iran' );
		$count = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 15;
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
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? absint( $new_instance['count'] ) : 15;
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
 * Register all widgets
 */
function iran_news_register_widgets() {
	register_widget( 'Iran_News_Popular_Posts_Widget' );
	register_widget( 'Iran_News_Latest_Posts_List_Widget' );
	register_widget( 'Iran_News_Ad_Widget' );
}
add_action( 'widgets_init', 'iran_news_register_widgets' );
