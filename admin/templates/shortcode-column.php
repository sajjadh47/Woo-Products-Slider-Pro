<div class="meta-box-sortables ui-sortable">
	<div class="postbox">
		<button type="button" class="handlediv" aria-expanded="true" data-toggle="collapse" data-target="#<?php echo $options['id']; ?>">
			<span class="screen-reader-text"><?php echo __( 'Toggle Panel','woo-products-slider-pro' ); ?></span>
			<span class="toggle-indicator" aria-hidden="true"></span>
		</button>
		<!-- Toggle -->

		<h2 class="hndle"><span><?php echo $options['title']; ?></span></h2>

		<div class="inside collapse show" id="<?php echo $options['id']; ?>">
			<div class="woopsp_shortcode">
				<p class="float-left"><code class="slider_shortcode_code">[<?php echo $options['shortcode']; ?>]</code></p>
				<button class="button-secondary float-right" data-toggle="collapse" data-target=".form_<?php echo $options['id']; ?>"><?php echo __( 'Customize Shortcode','woo-products-slider-pro' ); ?></button>
			</div>

			<form class="collapse customize_shortcode_form form_<?php echo $options['id']; ?>" data-shortcode="<?php echo $options['shortcode']; ?>">
				<div class="row">
					<div class="form-group col-md-12">
						<label for="<?php echo $options['id']; ?>_specific_products_filter"><?php echo __( 'Show Specific Products Only','woo-products-slider-pro' ); ?></label>
						<select name="specific_products_filter" id="<?php echo $options['id']; ?>_specific_products_filter" class="specific_products_filter form-control" multiple="multiple"></select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12">
						<label for="<?php echo $options['id']; ?>_stock_status_filter"><?php echo __( 'Filter By Stock Status','woo-products-slider-pro' ); ?></label>
						<select name="stock_status" id="<?php echo $options['id']; ?>_stock_status_filter" class="select2 stock_status_filter form-control">
							<?php echo woopspro_get_woo_stock_status_option_html(); ?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12">
						<label for="<?php echo $options['id']; ?>_cat_filter"><?php echo __( 'Filter By Category','woo-products-slider-pro' ); ?></label>
						<select name="cat_filter" id="<?php echo $options['id']; ?>_cat_filter" class="select2 cat_filter form-control" multiple="multiple">
							<?php echo woopspro_get_woo_cats_option_html(); ?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12">
						<label for="<?php echo $options['id']; ?>_tag_filter"><?php echo __( 'Filter By Tag','woo-products-slider-pro' ); ?></label>
						<select name="tag_filter" id="<?php echo $options['id']; ?>_tag_filter" class="select2 tag_filter form-control" multiple="multiple">
							<?php echo woopspro_get_woo_tags_option_html(); ?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12">
						<label for="<?php echo $options['id']; ?>_sku_filter"><?php echo __( 'Filter By SKU','woo-products-slider-pro' ); ?></label>
						<select name="sku_filter" id="<?php echo $options['id']; ?>_sku_filter" class="select2 sku_filter form-control" multiple="multiple"></select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12">
						<label for="<?php echo $options['id']; ?>_attribute_filter"><?php echo __( 'Filter By Attributes','woo-products-slider-pro' ); ?></label>
						<select name="attribute_filter" id="<?php echo $options['id']; ?>_attribute_filter" class="select2 attribute_filter form-control" multiple="multiple">
							<?php echo woopspro_get_woo_attributes_option_html(); ?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4">
						<label for="<?php echo $options['id']; ?>_limit"><?php echo __( 'Total Products To Query : Default All (-1)','woo-products-slider-pro' ); ?></label>
						<input type="text" name="limit" id="<?php echo $options['id']; ?>_limit" class="form-control">
					</div>

					<div class="form-group col-md-4">
						<label for="<?php echo $options['id']; ?>_slide_to_show"><?php echo __( 'Total Products To Show in a Slider : Default 3','woo-products-slider-pro' ); ?></label>
						<input type="text" name="slide_to_show" id="<?php echo $options['id']; ?>_slide_to_show" class="form-control">
					</div>

					<div class="form-group col-md-4">
						<label for="<?php echo $options['id']; ?>_slide_to_scroll"><?php echo __( 'Total Products Slide Each Time : Default 3','woo-products-slider-pro' ); ?></label>
						<input type="text" name="slide_to_scroll" id="<?php echo $options['id']; ?>_slide_to_scroll" class="form-control">
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4">
						<label for="<?php echo $options['id']; ?>_slide_to_show_for_mobile"><?php echo __( 'Total Products To Show in a Slider For Mobile Devices ( 320px — 480px ) : Default 1','woo-products-slider-pro' ); ?></label>
						<input type="text" name="slide_to_show_for_mobile" id="<?php echo $options['id']; ?>_slide_to_show_for_mobile" class="form-control">
					</div>

					<div class="form-group col-md-4">
						<label for="<?php echo $options['id']; ?>_slide_to_scroll_for_mobile"><?php echo __( 'Total Products Slide Each Time For Mobile Devices ( 320px — 480px ) : Default 1','woo-products-slider-pro' ); ?></label>
						<input type="text" name="slide_to_scroll_for_mobile" id="<?php echo $options['id']; ?>_slide_to_scroll_for_mobile" class="form-control">
					</div>

					<div class="form-group col-md-4">
						<label for="<?php echo $options['id']; ?>_slide_to_show_for_tablet"><?php echo __( 'Total Products To Show in a Slider For iPads/Tablets Devices ( 481px — 768px ) : Default 2','woo-products-slider-pro' ); ?></label>
						<input type="text" name="slide_to_show_for_tablet" id="<?php echo $options['id']; ?>_slide_to_show_for_tablet" class="form-control">
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4">
						<label for="<?php echo $options['id']; ?>_slide_to_scroll_for_tablet"><?php echo __( 'Total Products Slide Each Time For iPads/Tablets Devices ( 481px — 768px ) : Default 2','woo-products-slider-pro' ); ?></label>
						<input type="text" name="slide_to_scroll_for_tablet" id="<?php echo $options['id']; ?>_slide_to_scroll_for_tablet" class="form-control">
					</div>
					
					<div class="form-group col-md-4">
						<label for="<?php echo $options['id']; ?>_slide_to_show_for_laptop"><?php echo __( 'Total Products To Show in a Slider For Laptop/Small Devices ( 769px — 1024px ) : Default 3','woo-products-slider-pro' ); ?></label>
						<input type="text" name="slide_to_show_for_laptop" id="<?php echo $options['id']; ?>_slide_to_show_for_laptop" class="form-control">
					</div>

					<div class="form-group col-md-4">
						<label for="<?php echo $options['id']; ?>_slide_to_scroll_for_laptop"><?php echo __( 'Total Products Slide Each Time For Laptop/Small Devices ( 769px — 1024px ) : Default 3','woo-products-slider-pro' ); ?></label>
						<input type="text" name="slide_to_scroll_for_laptop" id="<?php echo $options['id']; ?>_slide_to_scroll_for_laptop" class="form-control">
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4">
						<label for="<?php echo $options['id']; ?>_autoplay_speed">
							<?php echo __( 'Slider Autoplay Speed ( Default : 3000 miliseconds )
							[ Note : 1 second = 1000 milisecond ]','woo-products-slider-pro' ); ?>
						</label>
						<input type="text" name="autoplay_speed" class="form-control" value="" id="<?php echo $options['id']; ?>_autoplay_speed">
					</div>

					<div class="form-group col-md-4">
						<div class="form-check">
							<label class="form-check-label" for="<?php echo $options['id']; ?>_autoplay">
								<?php echo __( "Don't Autoplay Slide ( Default : Yes )",'woo-products-slider-pro' ); ?>
							</label>
							<input type="checkbox" name="autoplay" class="form-check-input" value="false" id="<?php echo $options['id']; ?>_autoplay">
						</div>
					</div>

					<div class="form-group col-md-4">
						<div class="form-check">
							<label class="form-check-label" for="<?php echo $options['id']; ?>_arrows">
								<?php echo __( "Don't Show Arrows ( Default : Yes )",'woo-products-slider-pro' ); ?>
							</label>
							<input type="checkbox" name="arrows" class="form-check-input" value="false" id="<?php echo $options['id']; ?>_arrows" >
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4">
						<div class="form-check">
							<label class="form-check-label" for="<?php echo $options['id']; ?>_dots">
								<?php echo __( "Don't Show Dots ( Default : Yes )",'woo-products-slider-pro' ); ?>
							</label>
							<input type="checkbox" name="dots" class="form-check-input" value="false" id="<?php echo $options['id']; ?>_dots">
						</div>
					</div>

					<div class="form-group col-md-4">
						<div class="form-check">
							<label class="form-check-label" for="<?php echo $options['id']; ?>_rtl">
								<?php echo __( "Slide Right To Left ( Default : No )",'woo-products-slider-pro' ); ?>
							</label>
							<input type="checkbox" name="rtl" class="form-check-input" value="true" id="<?php echo $options['id']; ?>_rtl">
						</div>
					</div>

					<div class="form-group col-md-4">
						<button type="button" class="button-primary generate_btn">
							<?php echo __( "Generate Customized Shortcode",'woo-products-slider-pro' ); ?>
						</button>
					</div>
				</div>
			</form>

		</div><!-- .inside -->

	</div><!-- .postbox -->

</div><!-- .meta-box-sortables .ui-sortable -->