<?php
/**
 * Font icon functions used in the theme.
 *
 * @package    Extant
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015, Justin Tadlock
 * @link       http://themehybrid.com/themes/extant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Returns the font icon code (e.g., `f001`).
 *
 * @since  1.0.0
 * @access public
 * @param  string  $name
 * @return string
 */
function extant_get_font_icon_code( $name ) {

	$icons = extant_get_font_icons();

	return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}

/**
 * Returns the font icon HTML character (e.g., `&#xf001`).
 *
 * @since  1.0.0
 * @access public
 * @param  string  $name
 * @return string
 */
function extant_get_font_icon_html( $name ) {

	$icon = extant_get_font_icon_code( $name );

	return $icon ? "&#x{$icon}" : '';
}

/**
 * Returns the font icon code for use in CSS (e.g., `\f001`).
 *
 * @since  1.0.0
 * @access public
 * @param  string  $name
 * @return string
 */
function extant_get_font_icon_css( $name ) {

	$icon = extant_get_font_icon_code( $name );

	return $icon ? "\\{$icon}" : '';
}

/**
 * Checks if a font icon exists.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $name
 * @return bool
 */
function extant_font_icon_exists( $name ) {

	$name = extant_get_font_icons();

	return isset( $icons[ $name ] );
}

/**
 * Validation function for font icons.  Checks if the icon exists.  If so,
 * it returns the icon.  Else, it returns the fallback.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $icon
 * @return string
 */
function extant_validate_font_icon( $icon ) {

	return extant_font_icon_exists( $icon ) ? $icon : '';
}

/**
 * Returns an array of font icon class names (key) and codes (value).  By default,
 * this uses Font Awesome.  However, devs can plug in their preferred icon set.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function extant_get_font_icons() {

	$icons = array(
		'icon-adjust'               => 'f042',
		'icon-adn'                  => 'f170',
		'icon-align-center'         => 'f037',
		'icon-align-justify'        => 'f039',
		'icon-align-left'           => 'f036',
		'icon-align-right'          => 'f038',
		'icon-ambulance'            => 'f0f9',
		'icon-anchor'               => 'f13d',
		'icon-android'              => 'f17b',
		'icon-angle-double-down'    => 'f103',
		'icon-angle-double-left'    => 'f100',
		'icon-angle-double-right'   => 'f101',
		'icon-angle-double-up'      => 'f102',
		'icon-angle-down'           => 'f107',
		'icon-angle-left'           => 'f104',
		'icon-angle-right'          => 'f105',
		'icon-angle-up'             => 'f106',
		'icon-apple'                => 'f179',
		'icon-archive'              => 'f187',
		'icon-arrow-circle-down'    => 'f0ab',
		'icon-arrow-circle-left'    => 'f0a8',
		'icon-arrow-circle-o-down'  => 'f01a',
		'icon-arrow-circle-o-left'  => 'f190',
		'icon-arrow-circle-o-right' => 'f18e',
		'icon-arrow-circle-o-up'    => 'f01b',
		'icon-arrow-circle-right'   => 'f0a9',
		'icon-arrow-circle-up'      => 'f0aa',
		'icon-arrow-down'           => 'f063',
		'icon-arrow-left'           => 'f060',
		'icon-arrow-right'          => 'f061',
		'icon-arrow-up'             => 'f062',
		'icon-arrows'               => 'f047',
		'icon-arrows-alt'           => 'f0b2',
		'icon-arrows-h'             => 'f07e',
		'icon-arrows-v'             => 'f07d',
		'icon-asterisk'             => 'f069',
		'icon-automobile'           => 'f1b9',
		'icon-backward'             => 'f04a',
		'icon-ban'                  => 'f05e',
		'icon-bank'                 => 'f19c',
		'icon-bar-chart-o'          => 'f080',
		'icon-barcode'              => 'f02a',
		'icon-bars'                 => 'f0c9',
		'icon-beer'                 => 'f0fc',
		'icon-behance'              => 'f1b4',
		'icon-behance-square'       => 'f1b5',
		'icon-bell' => 'f0f3',
		'icon-bell-o' => 'f0a2',
		'icon-bitbucket' => 'f171',
		'icon-bitbucket-square' => 'f172',
		'icon-bitcoin' => 'f15a',
		'icon-bold' => 'f032',
		'icon-bolt' => 'f0e7',
		'icon-bomb' => 'f1e2',
		'icon-book' => 'f02d',
		'icon-bookmark' => 'f02e',
		'icon-bookmark-o' => 'f097',
		'icon-briefcase' => 'f0b1',
		'icon-btc' => 'f15a',
		'icon-bug' => 'f188',
		'icon-building' => 'f1ad',
		'icon-building-o' => 'f0f7',
		'icon-bullhorn' => 'f0a1',
		'icon-bullseye' => 'f140',
		'icon-cab' => 'f1ba',
		'icon-calendar' => 'f073',
		'icon-calendar-o' => 'f133',
		'icon-camera' => 'f030',
		'icon-camera-retro' => 'f083',
		'icon-car' => 'f1b9',
		'icon-caret-down' => 'f0d7',
		'icon-caret-left' => 'f0d9',
		'icon-caret-right' => 'f0da',
		'icon-caret-square-o-down' => 'f150',
		'icon-caret-square-o-left' => 'f191',
		'icon-caret-square-o-right' => 'f152',
		'icon-caret-square-o-up' => 'f151',
		'icon-caret-up' => 'f0d8',
		'icon-certificate' => 'f0a3',
		'icon-chain' => 'f0c1',
		'icon-chain-broken' => 'f127',
		'icon-check' => 'f00c',
		'icon-check-circle' => 'f058',
		'icon-check-circle-o' => 'f05d',
		'icon-check-square' => 'f14a',
		'icon-check-square-o' => 'f046',
		'icon-chevron-circle-down' => 'f13a',
		'icon-chevron-circle-left' => 'f137',
		'icon-chevron-circle-right' => 'f138',
		'icon-chevron-circle-up' => 'f139',
		'icon-chevron-down' => 'f078',
		'icon-chevron-left' => 'f053',
		'icon-chevron-right' => 'f054',
		'icon-chevron-up' => 'f077',
		'icon-child' => 'f1ae',
		'icon-circle' => 'f111',
		'icon-circle-o' => 'f10c',
		'icon-circle-o-notch' => 'f1ce',
		'icon-circle-thin' => 'f1db',
		'icon-clipboard' => 'f0ea',
		'icon-clock-o' => 'f017',
		'icon-cloud' => 'f0c2',
		'icon-cloud-download' => 'f0ed',
		'icon-cloud-upload' => 'f0ee',
		'icon-cny' => 'f157',
		'icon-code' => 'f121',
		'icon-code-fork' => 'f126',
		'icon-codepen' => 'f1cb',
		'icon-coffee' => 'f0f4',
		'icon-cog' => 'f013',
		'icon-cogs' => 'f085',
		'icon-columns' => 'f0db',
		'icon-comment' => 'f075',
		'icon-comment-o' => 'f0e5',
		'icon-comments' => 'f086',
		'icon-comments-o' => 'f0e6',
		'icon-compass' => 'f14e',
		'icon-compress' => 'f066',
		'icon-copy' => 'f0c5',
		'icon-credit-card' => 'f09d',
		'icon-crop' => 'f125',
		'icon-crosshairs' => 'f05b',
		'icon-css3' => 'f13c',
		'icon-cube' => 'f1b2',
		'icon-cubes' => 'f1b3',
		'icon-cut' => 'f0c4',
		'icon-cutlery' => 'f0f5',
		'icon-dashboard' => 'f0e4',
		'icon-database' => 'f1c0',
		'icon-dedent' => 'f03b',
		'icon-delicious' => 'f1a5',
		'icon-desktop' => 'f108',
		'icon-deviantart' => 'f1bd',
		'icon-digg' => 'f1a6',
		'icon-dollar' => 'f155',
		'icon-dot-circle-o' => 'f192',
		'icon-download' => 'f019',
		'icon-dribbble' => 'f17d',
		'icon-dropbox' => 'f16b',
		'icon-drupal' => 'f1a9',
		'icon-edit' => 'f044',
		'icon-eject' => 'f052',
		'icon-ellipsis-h' => 'f141',
		'icon-ellipsis-v' => 'f142',
		'icon-empire' => 'f1d1',
		'icon-envelope' => 'f0e0',
		'icon-envelope-o' => 'f003',
		'icon-envelope-square' => 'f199',
		'icon-eraser' => 'f12d',
		'icon-eur' => 'f153',
		'icon-euro' => 'f153',
		'icon-exchange' => 'f0ec',
		'icon-exclamation' => 'f12a',
		'icon-exclamation-circle' => 'f06a',
		'icon-exclamation-triangle' => 'f071',
		'icon-expand' => 'f065',
		'icon-external-link' => 'f08e',
		'icon-external-link-square' => 'f14c',
		'icon-eye' => 'f06e',
		'icon-eye-slash' => 'f070',
		'icon-facebook' => 'f09a',
		'icon-facebook-square' => 'f082',
		'icon-fast-backward' => 'f049',
		'icon-fast-forward' => 'f050',
		'icon-fax' => 'f1ac',
		'icon-female' => 'f182',
		'icon-fighter-jet' => 'f0fb',
		'icon-file' => 'f15b',
		'icon-file-archive-o' => 'f1c6',
		'icon-file-audio-o' => 'f1c7',
		'icon-file-code-o' => 'f1c9',
		'icon-file-excel-o' => 'f1c3',
		'icon-file-image-o' => 'f1c5',
		'icon-file-movie-o' => 'f1c8',
		'icon-file-o' => 'f016',
		'icon-file-pdf-o' => 'f1c1',
		'icon-file-photo-o' => 'f1c5',
		'icon-file-picture-o' => 'f1c5',
		'icon-file-powerpoint-o' => 'f1c4',
		'icon-file-sound-o' => 'f1c7',
		'icon-file-text' => 'f15c',
		'icon-file-text-o' => 'f0f6',
		'icon-file-video-o' => 'f1c8',
		'icon-file-word-o' => 'f1c2',
		'icon-file-zip-o' => 'f1c6',
		'icon-files-o' => 'f0c5',
		'icon-film' => 'f008',
		'icon-filter' => 'f0b0',
		'icon-fire' => 'f06d',
		'icon-fire-extinguisher' => 'f134',
		'icon-flag' => 'f024',
		'icon-flag-checkered' => 'f11e',
		'icon-flag-o' => 'f11d',
		'icon-flash' => 'f0e7',
		'icon-flask' => 'f0c3',
		'icon-flickr' => 'f16e',
		'icon-floppy-o' => 'f0c7',
		'icon-folder' => 'f07b',
		'icon-folder-o' => 'f114',
		'icon-folder-open' => 'f07c',
		'icon-folder-open-o' => 'f115',
		'icon-font' => 'f031',
		'icon-forward' => 'f04e',
		'icon-foursquare' => 'f180',
		'icon-frown-o' => 'f119',
		'icon-gamepad' => 'f11b',
		'icon-gavel' => 'f0e3',
		'icon-gbp' => 'f154',
		'icon-ge' => 'f1d1',
		'icon-gear' => 'f013',
		'icon-gears' => 'f085',
		'icon-gift' => 'f06b',
		'icon-git' => 'f1d3',
		'icon-git-square' => 'f1d2',
		'icon-github' => 'f09b',
		'icon-github-alt' => 'f113',
		'icon-github-square' => 'f092',
		'icon-gittip' => 'f184',
		'icon-glass' => 'f000',
		'icon-globe' => 'f0ac',
		'icon-google' => 'f1a0',
		'icon-google-plus' => 'f0d5',
		'icon-google-plus-square' => 'f0d4',
		'icon-graduation-cap' => 'f19d',
		'icon-group' => 'f0c0',
		'icon-h-square' => 'f0fd',
		'icon-hacker-news' => 'f1d4',
		'icon-hand-o-down' => 'f0a7',
		'icon-hand-o-left' => 'f0a5',
		'icon-hand-o-right' => 'f0a4',
		'icon-hand-o-up' => 'f0a6',
		'icon-hdd-o' => 'f0a0',
		'icon-header' => 'f1dc',
		'icon-headphones' => 'f025',
		'icon-heart' => 'f004',
		'icon-heart-o' => 'f08a',
		'icon-history' => 'f1da',
		'icon-home' => 'f015',
		'icon-hospital-o' => 'f0f8',
		'icon-html5' => 'f13b',
		'icon-image' => 'f03e',
		'icon-inbox' => 'f01c',
		'icon-indent' => 'f03c',
		'icon-info' => 'f129',
		'icon-info-circle' => 'f05a',
		'icon-inr' => 'f156',
		'icon-instagram' => 'f16d',
		'icon-institution' => 'f19c',
		'icon-italic' => 'f033',
		'icon-joomla' => 'f1aa',
		'icon-jpy' => 'f157',
		'icon-jsfiddle' => 'f1cc',
		'icon-key' => 'f084',
		'icon-keyboard-o' => 'f11c',
		'icon-krw' => 'f159',
		'icon-language' => 'f1ab',
		'icon-laptop' => 'f109',
		'icon-leaf' => 'f06c',
		'icon-legal' => 'f0e3',
		'icon-lemon-o' => 'f094',
		'icon-level-down' => 'f149',
		'icon-level-up' => 'f148',
		'icon-life-bouy' => 'f1cd',
		'icon-life-ring' => 'f1cd',
		'icon-life-saver' => 'f1cd',
		'icon-lightbulb-o' => 'f0eb',
		'icon-link' => 'f0c1',
		'icon-linkedin' => 'f0e1',
		'icon-linkedin-square' => 'f08c',
		'icon-linux' => 'f17c',
		'icon-list' => 'f03a',
		'icon-list-alt' => 'f022',
		'icon-list-ol' => 'f0cb',
		'icon-list-ul' => 'f0ca',
		'icon-location-arrow' => 'f124',
		'icon-lock' => 'f023',
		'icon-long-arrow-down' => 'f175',
		'icon-long-arrow-left' => 'f177',
		'icon-long-arrow-right' => 'f178',
		'icon-long-arrow-up' => 'f176',
		'icon-magic' => 'f0d0',
		'icon-magnet' => 'f076',
		'icon-mail-forward' => 'f064',
		'icon-mail-reply' => 'f112',
		'icon-mail-reply-all' => 'f122',
		'icon-male' => 'f183',
		'icon-map-marker' => 'f041',
		'icon-maxcdn' => 'f136',
		'icon-medkit' => 'f0fa',
		'icon-meh-o' => 'f11a',
		'icon-microphone' => 'f130',
		'icon-microphone-slash' => 'f131',
		'icon-minus' => 'f068',
		'icon-minus-circle' => 'f056',
		'icon-minus-square' => 'f146',
		'icon-minus-square-o' => 'f147',
		'icon-mobile' => 'f10b',
		'icon-mobile-phone' => 'f10b',
		'icon-money' => 'f0d6',
		'icon-moon-o' => 'f186',
		'icon-mortar-board' => 'f19d',
		'icon-music' => 'f001',
		'icon-navicon' => 'f0c9',
		'icon-openid' => 'f19b',
		'icon-outdent' => 'f03b',
		'icon-pagelines' => 'f18c',
		'icon-paper-plane' => 'f1d8',
		'icon-paper-plane-o' => 'f1d9',
		'icon-paperclip' => 'f0c6',
		'icon-paragraph' => 'f1dd',
		'icon-paste' => 'f0ea',
		'icon-pause' => 'f04c',
		'icon-paw' => 'f1b0',
		'icon-pencil' => 'f040',
		'icon-pencil-square' => 'f14b',
		'icon-pencil-square-o' => 'f044',
		'icon-phone' => 'f095',
		'icon-phone-square' => 'f098',
		'icon-photo' => 'f03e',
		'icon-picture-o' => 'f03e',
		'icon-pied-piper' => 'f1a7',
		'icon-pied-piper-alt' => 'f1a8',
		'icon-pied-piper-square' => 'f1a7',
		'icon-pinterest' => 'f0d2',
		'icon-pinterest-square' => 'f0d3',
		'icon-plane' => 'f072',
		'icon-play' => 'f04b',
		'icon-play-circle' => 'f144',
		'icon-play-circle-o' => 'f01d',
		'icon-plus' => 'f067',
		'icon-plus-circle' => 'f055',
		'icon-plus-square' => 'f0fe',
		'icon-plus-square-o' => 'f196',
		'icon-power-off' => 'f011',
		'icon-print' => 'f02f',
		'icon-puzzle-piece' => 'f12e',
		'icon-qq' => 'f1d6',
		'icon-qrcode' => 'f029',
		'icon-question' => 'f128',
		'icon-question-circle' => 'f059',
		'icon-quote-left' => 'f10d',
		'icon-quote-right' => 'f10e',
		'icon-ra' => 'f1d0',
		'icon-random' => 'f074',
		'icon-rebel' => 'f1d0',
		'icon-recycle' => 'f1b8',
		'icon-reddit' => 'f1a1',
		'icon-reddit-square' => 'f1a2',
		'icon-refresh' => 'f021',
		'icon-renren' => 'f18b',
		'icon-reorder' => 'f0c9',
		'icon-repeat' => 'f01e',
		'icon-reply' => 'f112',
		'icon-reply-all' => 'f122',
		'icon-retweet' => 'f079',
		'icon-rmb' => 'f157',
		'icon-road' => 'f018',
		'icon-rocket' => 'f135',
		'icon-rotate-left' => 'f0e2',
		'icon-rotate-right' => 'f01e',
		'icon-rouble' => 'f158',
		'icon-rss' => 'f09e',
		'icon-rss-square' => 'f143',
		'icon-rub' => 'f158',
		'icon-ruble' => 'f158',
		'icon-rupee' => 'f156',
		'icon-save' => 'f0c7',
		'icon-scissors' => 'f0c4',
		'icon-search' => 'f002',
		'icon-search-minus' => 'f010',
		'icon-search-plus' => 'f00e',
		'icon-send' => 'f1d8',
		'icon-send-o' => 'f1d9',
		'icon-share' => 'f064',
		'icon-share-alt' => 'f1e0',
		'icon-share-alt-square' => 'f1e1',
		'icon-share-square' => 'f14d',
		'icon-share-square-o' => 'f045',
		'icon-shield' => 'f132',
		'icon-shopping-cart' => 'f07a',
		'icon-sign-in' => 'f090',
		'icon-sign-out' => 'f08b',
		'icon-signal' => 'f012',
		'icon-sitemap' => 'f0e8',
		'icon-skype' => 'f17e',
		'icon-slack' => 'f198',
		'icon-sliders' => 'f1de',
		'icon-smile-o' => 'f118',
		'icon-sort' => 'f0dc',
		'icon-sort-alpha-asc' => 'f15d',
		'icon-sort-alpha-desc' => 'f15e',
		'icon-sort-amount-asc' => 'f160',
		'icon-sort-amount-desc' => 'f161',
		'icon-sort-asc' => 'f0de',
		'icon-sort-desc' => 'f0dd',
		'icon-sort-down' => 'f0dd',
		'icon-sort-numeric-asc' => 'f162',
		'icon-sort-numeric-desc' => 'f163',
		'icon-sort-up' => 'f0de',
		'icon-soundcloud' => 'f1be',
		'icon-space-shuttle' => 'f197',
		'icon-spinner' => 'f110',
		'icon-spoon' => 'f1b1',
		'icon-spotify' => 'f1bc',
		'icon-square' => 'f0c8',
		'icon-square-o' => 'f096',
		'icon-stack-exchange' => 'f18d',
		'icon-stack-overflow' => 'f16c',
		'icon-star' => 'f005',
		'icon-star-half' => 'f089',
		'icon-star-half-empty' => 'f123',
		'icon-star-half-full' => 'f123',
		'icon-star-half-o' => 'f123',
		'icon-star-o' => 'f006',
		'icon-steam' => 'f1b6',
		'icon-steam-square' => 'f1b7',
		'icon-step-backward' => 'f048',
		'icon-step-forward' => 'f051',
		'icon-stethoscope' => 'f0f1',
		'icon-stop' => 'f04d',
		'icon-strikethrough' => 'f0cc',
		'icon-stumbleupon' => 'f1a4',
		'icon-stumbleupon-circle' => 'f1a3',
		'icon-subscript' => 'f12c',
		'icon-suitcase' => 'f0f2',
		'icon-sun-o' => 'f185',
		'icon-superscript' => 'f12b',
		'icon-support' => 'f1cd',
		'icon-table' => 'f0ce',
		'icon-tablet' => 'f10a',
		'icon-tachometer' => 'f0e4',
		'icon-tag' => 'f02b',
		'icon-tags' => 'f02c',
		'icon-tasks' => 'f0ae',
		'icon-taxi' => 'f1ba',
		'icon-tencent-weibo' => 'f1d5',
		'icon-terminal' => 'f120',
		'icon-text-height' => 'f034',
		'icon-text-width' => 'f035',
		'icon-th' => 'f00a',
		'icon-th-large' => 'f009',
		'icon-th-list' => 'f00b',
		'icon-thumb-tack' => 'f08d',
		'icon-thumbs-down' => 'f165',
		'icon-thumbs-o-down' => 'f088',
		'icon-thumbs-o-up' => 'f087',
		'icon-thumbs-up' => 'f164',
		'icon-ticket' => 'f145',
		'icon-times' => 'f00d',
		'icon-times-circle' => 'f057',
		'icon-times-circle-o' => 'f05c',
		'icon-tint' => 'f043',
		'icon-toggle-down' => 'f150',
		'icon-toggle-left' => 'f191',
		'icon-toggle-right' => 'f152',
		'icon-toggle-up' => 'f151',
		'icon-trash-o' => 'f014',
		'icon-tree' => 'f1bb',
		'icon-trello' => 'f181',
		'icon-trophy' => 'f091',
		'icon-truck' => 'f0d1',
		'icon-try' => 'f195',
		'icon-tumblr' => 'f173',
		'icon-tumblr-square' => 'f174',
		'icon-turkish-lira' => 'f195',
		'icon-twitter' => 'f099',
		'icon-twitter-square' => 'f081',
		'icon-umbrella' => 'f0e9',
		'icon-underline' => 'f0cd',
		'icon-undo' => 'f0e2',
		'icon-university' => 'f19c',
		'icon-unlink' => 'f127',
		'icon-unlock' => 'f09c',
		'icon-unlock-alt' => 'f13e',
		'icon-unsorted' => 'f0dc',
		'icon-upload' => 'f093',
		'icon-usd' => 'f155',
		'icon-user' => 'f007',
		'icon-user-md' => 'f0f0',
		'icon-users' => 'f0c0',
		'icon-video-camera' => 'f03d',
		'icon-vimeo-square' => 'f194',
		'icon-vine' => 'f1ca',
		'icon-vk' => 'f189',
		'icon-volume-down' => 'f027',
		'icon-volume-off' => 'f026',
		'icon-volume-up' => 'f028',
		'icon-warning' => 'f071',
		'icon-wechat' => 'f1d7',
		'icon-weibo' => 'f18a',
		'icon-weixin' => 'f1d7',
		'icon-wheelchair' => 'f193',
		'icon-windows' => 'f17a',
		'icon-won' => 'f159',
		'icon-wordpress' => 'f19a',
		'icon-wrench' => 'f0ad',
		'icon-xing' => 'f168',
		'icon-xing-square' => 'f169',
		'icon-yahoo' => 'f19e',
		'icon-yen' => 'f157',
		'icon-youtube' => 'f167',
		'icon-youtube-play' => 'f16a',
		'icon-youtube-square' => 'f166'
	);

	return apply_filters( 'extant_font_icons', $icons );
}
