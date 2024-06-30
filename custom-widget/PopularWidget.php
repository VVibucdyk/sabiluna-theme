<?php

class PopularWidget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'my-custom-widget';
    }

    public function get_title() {
        return 'Sabiluna Popular Post';
    }

    public function get_icon() {
        return 'eicon-star';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function render() {
        ?>
        <div class="my-custom-widget">
            <h1>Hello, World!</h1>
        </div>
        <?php
    }

}