<?php
function sus_donate_meta_box(){
	add_meta_box( 'sus-donate', 'Donate', 'sus_donate', 'signup-form', 'normal', 'high' );	
}
add_action( 'add_meta_boxes', 'sus_donate_meta_box' );

function sus_donate(){ ?> 
	<div align="center">
		<h1>Want New Features, More Options, Continued Support and Development?</h1>

	    <a class="sus-donate-button" href="https://www.paypal.com/ca/cgi-bin/webscr?cmd=_flow&SESSION=ke6HYxEhAB6v_7AHHG35z1YodzMlrBeMPUU6D4iWQ-gV9_0UGXuzyua5L9y&dispatch=5885d80a13c0db1f8e263663d3faee8d0b9dcb01a9b6dc564e45f62871326a5e">Donate</a>
    </div>
<?php } ?>