<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class PopularWidget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'PopularWidget';
	}

	public function get_title() {
		return __( 'Sabiluna Popular Post Loop', 'sabiluna' );
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
				'default' => 'post_views_count',
				'options' => unidex_order_by(),
				'description' => __('Select post order by.', 'sabiluna'),
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
					'{{WRAPPER}} .PopularWidgetWrapper .popular-item .counter' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .PopularWidgetWrapper .popular-item .popular-item-content .topic-wrapper .topic' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title-typography',
				'label' => __('Title Typography '),
				'selector' => '{{WRAPPER}} .PopularWidgetWrapper .popular-item .popular-item-content .title',
			]
		);

		$this->add_control(
			'title-color',
			[
				'label' => __('Title Color', 'sabiluna'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .PopularWidgetWrapper .popular-item .popular-item-content .title' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt-typography',
				'label' => __('Category Typography '),
				'selector' => '{{WRAPPER}} .PopularWidgetWrapper .popular-item .popular-item-content .topic-wrapper .topic',
			]
		);

		$this->add_control(
			'excerpt-color',
			[
				'label' => __('Category Color', 'sabiluna'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .PopularWidgetWrapper .popular-item .popular-item-content .topic-wrapper .topic' => 'color: {{VALUE}};',
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

		include(plugin_dir_path(__FILE__) . 'tpl/PopularWidget.php');
	}

	protected function content_template()
	{
	}

	public function render_plain_content($instance = [])
	{
	}

}