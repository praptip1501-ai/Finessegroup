<?php
/**
 * Finesse Template Part: Section 12 - Contact
 *
 * @package Workstation
 * @since 1.0.0
 */

$contact_lbl   = get_theme_mod( 'finesse_contact_lbl', esc_html__( 'Contact', 'workstation' ) );
$contact_title = get_theme_mod( 'finesse_contact_title', esc_html__( 'Request a free quote', 'workstation' ) );
$contact_desc  = get_theme_mod( 'finesse_contact_desc', esc_html__( 'Share your project details and we\'ll get back to you with practical advice and the next steps.', 'workstation' ) );
$contact_phone = get_theme_mod( 'finesse_contact_phone', '0490 389 447' );
$contact_email = get_theme_mod( 'finesse_contact_email', 'daniel@finessegroup.au' );
$cf7_shortcode = get_theme_mod( 'finesse_contact_cf7_shortcode', '' );
?>

<section id="contact" class="contact-section" aria-label="<?php esc_attr_e( 'Contact & Quote Request', 'workstation' ); ?>">
	<div class="wrap">
		<div class="g-contact">
			<!-- Contact Left Column -->
			<div>
				<?php if ( file_exists( get_theme_file_path( 'assets/images/logo-white.png' ) ) ) : ?>
					<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/logo-white.png' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" style="height: 64px; width: auto; display: block; margin: 0 0 56px">
				<?php endif; ?>
				<p class="lbl" style="margin: 0 0 20px; color: #A3A3A3"><?php echo esc_html( $contact_lbl ); ?></p>
				<h2 class="rv contact-title"><?php echo esc_html( $contact_title ); ?></h2>
				<p class="rv contact-intro"><?php echo esc_html( $contact_desc ); ?></p>
				<div class="contact-links">
					<?php if ( $contact_phone ) : ?>
						<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $contact_phone ) ); ?>"><?php echo esc_html( $contact_phone ); ?></a>
					<?php endif; ?>
					<?php if ( $contact_email ) : ?>
						<a href="mailto:<?php echo esc_attr( $contact_email ); ?>"><?php echo esc_html( $contact_email ); ?></a>
					<?php endif; ?>
				</div>
			</div>

			<!-- Contact Right Column: CF7 Shortcode or Standalone Form -->
			<div>
				<?php if ( ! empty( $cf7_shortcode ) ) : ?>
					<div class="rv cf7-form-wrapper">
						<?php echo do_shortcode( wp_kses_post( $cf7_shortcode ) ); ?>
					</div>
				<?php else : ?>
					<form class="rv" id="quoteForm" aria-label="<?php esc_attr_e( 'Quote request', 'workstation' ); ?>">
						<div class="g-form">
							<div class="field">
								<label for="q-name"><?php esc_html_e( 'Name', 'workstation' ); ?></label>
								<input id="q-name" name="q_name" type="text" autocomplete="name" required>
							</div>
							<div class="field">
								<label for="q-phone"><?php esc_html_e( 'Phone', 'workstation' ); ?></label>
								<input id="q-phone" name="q_phone" type="tel" autocomplete="tel">
							</div>
							<div class="field">
								<label for="q-email"><?php esc_html_e( 'Email', 'workstation' ); ?></label>
								<input id="q-email" name="q_email" type="email" autocomplete="email" required>
							</div>
							<div class="field">
								<label for="q-suburb"><?php esc_html_e( 'Suburb', 'workstation' ); ?></label>
								<input id="q-suburb" name="q_suburb" type="text">
							</div>
							<div class="field" style="grid-column: 1 / -1">
								<label for="q-svc"><?php esc_html_e( 'Service', 'workstation' ); ?></label>
								<div class="select-wrap">
									<select id="q-svc" name="q_svc">
										<option value="" disabled selected><?php esc_html_e( 'Select a service', 'workstation' ); ?></option>
										<?php
										$contact_services = finesse_get_services_explorer_data();
										if ( ! empty( $contact_services ) ) :
											foreach ( $contact_services as $svc_item ) :
												$s_name = ! empty( $svc_item['name'] ) ? $svc_item['name'] : ( ! empty( $svc_item['short'] ) ? $svc_item['short'] : '' );
												if ( ! empty( $s_name ) ) :
													?>
													<option value="<?php echo esc_attr( $s_name ); ?>"><?php echo esc_html( $s_name ); ?></option>
													<?php
												endif;
											endforeach;
										else :
											?>
											<option value="Mechanical Polished Concrete"><?php esc_html_e( 'Mechanical Polished Concrete', 'workstation' ); ?></option>
											<option value="Grind & Seal Concrete"><?php esc_html_e( 'Grind & Seal Concrete', 'workstation' ); ?></option>
											<option value="Micro Cement"><?php esc_html_e( 'Micro Cement', 'workstation' ); ?></option>
											<option value="Epoxy & Flake Flooring"><?php esc_html_e( 'Epoxy & Flake Flooring', 'workstation' ); ?></option>
											<option value="Spray Resin"><?php esc_html_e( 'Spray Resin', 'workstation' ); ?></option>
											<option value="Concrete Preparation Grinding"><?php esc_html_e( 'Concrete Preparation Grinding', 'workstation' ); ?></option>
										<?php endif; ?>
										<option value="Not sure yet"><?php esc_html_e( 'Not sure yet', 'workstation' ); ?></option>
									</select>
									<span class="select-arrow" aria-hidden="true">
										<svg width="12" height="7" viewBox="0 0 12 7" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
											<path d="M1 1l5 4.5 5-4.5"></path>
										</svg>
									</span>
								</div>
							</div>
							<div class="field" style="grid-column: 1 / -1">
								<label for="q-msg"><?php esc_html_e( 'Project details', 'workstation' ); ?></label>
								<textarea id="q-msg" name="q_msg" rows="4"></textarea>
							</div>
						</div>
						<button type="submit" class="contact-submit"><?php esc_html_e( 'Send enquiry', 'workstation' ); ?></button>
						<p id="formNote" role="status" style="margin: 16px 0 0; font-size: 14px; color: #A3A3A3"></p>
					</form>
					<script>
						window.selectContactService = function(serviceName) {
							var qSvc = document.getElementById('q-svc');
							if (!qSvc || !serviceName) return;

							var target = String(serviceName).trim().toLowerCase();
							var found = false;

							for (var i = 0; i < qSvc.options.length; i++) {
								var optVal = qSvc.options[i].value.trim().toLowerCase();
								var optTxt = qSvc.options[i].text.trim().toLowerCase();
								if (!optVal) continue;

								if (optVal === target || optTxt === target || optVal.indexOf(target) !== -1 || target.indexOf(optVal) !== -1) {
									qSvc.selectedIndex = i;
									found = true;
									break;
								}
							}

							if (found) {
								qSvc.dispatchEvent(new Event('change', { bubbles: true }));
								qSvc.style.color = '#fff';
								qSvc.style.borderBottomColor = '#fff';
								setTimeout(function() {
									qSvc.style.borderBottomColor = '';
								}, 1400);
							}
						};

						document.addEventListener('DOMContentLoaded', function() {
							var qSvc = document.getElementById('q-svc');
							function syncSelectColor() {
								if (!qSvc) return;
								if (!qSvc.value) {
									qSvc.style.color = '#A3A3A3';
								} else {
									qSvc.style.color = '#fff';
								}
							}
							if (qSvc) {
								syncSelectColor();
								qSvc.addEventListener('change', syncSelectColor);
							}

							// Listen for clicks on links pointing to contact section
							document.addEventListener('click', function(e) {
								var link = e.target.closest('a[href*="#contact"]');
								if (!link) return;

								var svc = link.getAttribute('data-service');
								if (!svc && link.closest('#services')) {
									var nameEl = document.getElementById('infoName');
									if (nameEl && nameEl.textContent) {
										svc = nameEl.textContent.trim();
									}
								}

								if (svc) {
									window.selectContactService(svc);
								}
							});

							// Check URL parameters and hash on load
							try {
								var params = new URLSearchParams(window.location.search);
								var paramSvc = params.get('service');
								if (paramSvc) {
									window.selectContactService(paramSvc);
								} else if (window.location.hash && window.location.hash.indexOf('service=') !== -1) {
									var hashParts = window.location.hash.split('service=');
									if (hashParts[1]) {
										window.selectContactService(decodeURIComponent(hashParts[1].split('&')[0]));
									}
								}
							} catch (err) {}

							var qf = document.getElementById('quoteForm');
							if (qf) {
								qf.addEventListener('submit', function(e) {
									e.preventDefault();
									var note = document.getElementById('formNote');
									if (note) {
										note.textContent = '<?php echo esc_js( __( 'Thanks — your enquiry has been sent. We will get back to you shortly.', 'workstation' ) ); ?>';
										note.style.color = '#fff';
									}
									qf.reset();
									if (qSvc) {
										qSvc.selectedIndex = 0;
										syncSelectColor();
									}
								});
							}
						});
					</script>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
