<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class unidex_blog_loop extends \Elementor\Widget_Base {

	public function get_name() {
		return 'unidex_blog_loop';
	}

	public function get_title() {
		return __( 'Sabiluna Post Loop', 'sabiluna' );
	}

	public function get_icon() {
		return 'eicon-post';
	}

	public function get_categories() {
		return [ 'sabiluna-block' ];
	}

    protected function register_controls() {

    /*===========GENERAL CONTROL=============*/
        /*=========== ELEMENT SETTING=============*/
        $this->start_controls_section(
			'unidex_specialise_block',
			[
				'label' => __('Sabiluna Post Loop', 'sabiluna'),
			]
		);

		$this->add_responsive_control(
			'choose_column',
			[
				'label' => __('Column', 'sabiluna'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 2,
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => 2,
				'tablet_default' => 2,
				'mobile_default' => 1,
				'options' => [
					1 => __('1', 'sabiluna'),
					2 => __('2', 'sabiluna'),
					3 => __('3', 'sabiluna'),
					4 => __('4', 'sabiluna'),
				],
				'selectors' => [
					'{{WRAPPER}} .unidex-blog-loop-wrapper .swiper-wrapper' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'space_between',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Gap Blog Loop', 'sabiluna' ),
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .unidex-blog-loop-wrapper .swiper-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __('Post per Block', 'sabiluna'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '-1',
				'title' => __('Enter some text', 'sabiluna'),
				'description' => __('This option allow you to set how much post display in this block. ( -1 for all )', 'sabiluna'),
			]
		);

		$this->add_control(
			'post_type',
			[
				'label' => __('Post Type', 'sabiluna'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'multiple' => true,
				'default' => 'post',
				'options' => get_custom_and_default_post_types(),
				'description' => __('Select post type to display (default to Post Default).', 'sabiluna'),
			]
		);

		$this->add_control(
			'category',
			[
				'label' => __('Category', 'sabiluna'),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'default' => [],
				'options' => unidex_get_category(),
				'description' => __('Select category to display (default to All).', 'sabiluna'),
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __('Order By', 'sabiluna'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => unidex_order_by(),
				'description' => __('Select post order by.', 'sabiluna'),
			]
		);

		$this->add_control(
			'orderby_option',
			[
				'label' => __('DESC or ASC', 'sabiluna'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'desc' => "DESC",
					'asc' => "ASC"
				],
				'description' => __('Select post order behaviour.', 'sabiluna'),
			]
		);

		$this->end_controls_section();

		/*===========. STYLE LOOP 2 SETTING =============*/
		$this->start_controls_section(
			'section_item_style',
			[
				'label' => __('Post Style Settings', 'sabiluna'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'bg-color',
			[
				'label' => __('Bacgkround Color Card', 'sabiluna'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .unidex-blog-loop-wrapper .card-wrapper' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'bg-color1',
			[
				'label' => __('Bacgkround Color Read More', 'sabiluna'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .unidex-blog-loop-wrapper .card-wrapper .card-description .footer-card a' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title-typography',
				'label' => __('Title Typography '),
				'selector' => '{{WRAPPER}} .unidex-blog-loop-wrapper .card-wrapper .card-description .title a',
			]
		);

		$this->add_control(
			'title-color',
			[
				'label' => __('Title Color', 'sabiluna'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .unidex-blog-loop-wrapper .card-wrapper .card-description .title a' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt-typography',
				'label' => __('Excerpt Typography '),
				'selector' => '{{WRAPPER}} .unidex-blog-loop-wrapper .card-wrapper .card-description .title span',
			]
		);

		$this->add_control(
			'excerpt-color',
			[
				'label' => __('Excerpt Color', 'sabiluna'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .unidex-blog-loop-wrapper .card-wrapper .card-description .title span' => 'color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$instance = $this->get_settings();

		$posts_per_page = !empty($instance['posts_per_page']) ? $instance['posts_per_page'] : '-1';
		$orderby = !empty($instance['orderby']) ? $instance['orderby'] : '';
		$orderby_option = !empty($instance['orderby_option']) ? $instance['orderby_option'] : '';
		$post_type = !empty($instance['post_type']) ? $instance['post_type'] : '';
		$category = !empty($instance['category']) ? $instance['category'] : '';
		$id = uniqid();
		



		include(plugin_dir_path(__FILE__) . 'tpl/blog-loop.php');
	}

	protected function content_template()
	{
	}

	public function render_plain_content($instance = [])
	{
	}

}