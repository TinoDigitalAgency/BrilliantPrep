<?php
/**
 * Шаблон формы поиска (searchform.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
?>
<form role="search" method="get" class="search-form form-inline" action="<?php echo home_url( '/' ); ?>">
	<div class="form-group">
		<input type="search" class="form-control input-sm" id="search-field" placeholder="Search by author, test type, tags…" value="<?php echo get_search_query() ?>" name="s">
        <button type="submit" class="search-btn">
            <svg width="30px" height="30px" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <defs>
                    <rect id="path-1" x="0" y="0" width="1440" height="464"></rect>
                </defs>
                <g id="UI" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="bp-ui-Blog" transform="translate(-744.000000, -420.000000)">
                        <g id="Main">
                            <rect id="full-back" fill="#FFFFFF" x="0" y="0" width="1440" height="600"></rect>
                            <g id="blog" transform="translate(0.000000, 136.000000)">
                                <mask id="mask-2" fill="white">
                                    <use xlink:href="#path-1"></use>
                                </mask>
                                <use id="Mask" fill="#383373" xlink:href="#path-1"></use>
                                <g id="text" mask="url(#mask-2)">
                                    <g transform="translate(162.000000, 155.000000)" id="search">
                                        <g transform="translate(0.000000, 112.000000)">
                                            <rect id="btn-ia" fill="#FFFFFF" x="0" y="0" width="644" height="64"></rect>
                                            <g transform="translate(582.000000, 17.000000)" fill="#DE3C7D" fill-rule="nonzero" id="Shape">
                                                <path d="M29.8168359,28.0492969 L21.1020703,19.3345312 C22.755,17.2938867 23.7499805,14.6995898 23.7499805,11.8750195 C23.7499805,5.32716797 18.4228125,0 11.8749609,0 C5.32710937,0 0,5.32716797 0,11.8750195 C0,18.4228711 5.32716797,23.7500391 11.8750195,23.7500391 C14.6995898,23.7500391 17.2938867,22.755 19.3345312,21.1021289 L28.0492969,29.8168945 C28.293457,30.0609375 28.689082,30.0609375 28.9332422,29.8168945 L29.8168945,28.9331836 C30.0609375,28.689082 30.0609375,28.2933398 29.8168359,28.0492969 Z M11.8750195,21.2500195 C6.70535156,21.2500195 2.50001953,17.0446875 2.50001953,11.8750195 C2.50001953,6.70535156 6.70535156,2.50001953 11.8750195,2.50001953 C17.0446875,2.50001953 21.2500195,6.70535156 21.2500195,11.8750195 C21.2500195,17.0446875 17.0446875,21.2500195 11.8750195,21.2500195 Z"></path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>
        </button>
	</div>
</form>