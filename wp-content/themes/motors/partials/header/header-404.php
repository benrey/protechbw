<?php $logo_main = stm_me_get_wpcfto_img_src('logo', get_template_directory_uri() . '/assets/images/tmp/logo.png'); ?>

<?php if(!empty($logo_main)): ?>
	<div class="error-header">
		<div class="text-center">
			<div class="dp-in">
				<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php esc_html_e('Home', 'motors'); ?>">
					<img src="<?php echo esc_url($logo_main); ?>" style="width: <?php echo stm_me_get_wpcfto_mod( 'logo_width', '138' ); ?>px;" alt="<?php esc_attr_e('Logo', 'motors');?>"/>
				</a>
			</div>
		</div>
	</div>
<?php endif; ?>