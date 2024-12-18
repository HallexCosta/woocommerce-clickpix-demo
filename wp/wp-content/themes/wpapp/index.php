<?php get_header(); ?>

<section class="home-section">
	<?php get_template_part('template-parts/logo', null); ?>
	<div class="box-invisible-normal"></div>
	
	<h1 class="title wow animate__animated animate__bounceInRight">WP APP</h1>
	
	<div class="box-invisible-normal"></div>
	<?php get_template_part('template-parts/form', 'contact', [
		'form_id' => 'home-form-contact'
	]); ?>
</section>

<script type="text/javascript">
  $$page = "home";
</script>

<?php get_footer(); ?>